<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-08-02
 * Time: 2:52 PM
 */

namespace Mithredate\FMSUpdater\Facades;


use Illuminate\Support\Facades\Facade;

class Zip extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'zip'; }

}