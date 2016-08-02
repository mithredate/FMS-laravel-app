<?php
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mithredate\FMSUpdater\Model\FMSUpdater;

/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-08-02
 * Time: 2:47 AM
 */
class FMSUpdaterTest extends FMSTestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function setUp(){
        // Path to Model Factories (within your package)
        $pathToFactories = realpath(dirname(__DIR__).'/src/database/factories');

        parent::setUp();

        // This overrides the $this->factory that is established in TestBench's setUp method above
        $this->factory = Factory::construct(\Faker\Factory::create(), $pathToFactories);

        // Continue with the rest of setUp for migrations, etc.
    }


    public function testFMSUpdaterModel(){
        $updater = FMSUpdater::first();
        $updater->update(['hash' => sha1(str_random())]);
        $this->seeInDatabase('fms_updater',['hash' => $updater->hash]);
    }

    public function testUpdatePage(){
        $updater = FMSUpdater::first();
        
        $updater->update(['hash' => sha1(str_random())]);
        $this->visit('fms-updater/update')
            ->see('newer version')
            ->dontSee('up to date');

        $this->visit('fms-updater/update')
            ->press('Update')
            ->seePageIs('fms-updater/update')
            ->see('Update Successful')
            ->see('up to date');

    }




}