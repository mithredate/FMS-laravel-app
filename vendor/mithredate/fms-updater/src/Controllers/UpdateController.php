<?php

namespace Mithredate\FMSUpdater\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests;
use Mithredate\FMSUpdater\Contracts\UpdateHandlerContract;

class UpdateController extends Controller
{

    /*
     * UpdateHandlerContract $updateHandler
     *
     * Holds an UpdateHandler instance
     * */
    private $updateHandler;

    /*
     * UpdateController constructor
     *
     * @param UpdateHandlerContract $handlerContract
     *
     * Stores an UpdateHandler instance in UpdateHandler instance
     * through the service container injection
     * */
    public function __construct(UpdateHandlerContract $handlerContract)
    {
        $this->updateHandler = $handlerContract;
    }


    public function index(){
        $hasUpdate = $this->updateHandler->checkForUpdates();
        return view('fms-updater::index', compact('hasUpdate'));
    }
    
    public function postUpdate(){
        if($this->updateHandler->checkForUpdates()){
            $this->updateHandler->performUpdate();
        }
        return redirect()->route('fms-updater.index');
    }
}
