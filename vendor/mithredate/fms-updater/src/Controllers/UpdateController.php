<?php

namespace Mithredate\FMSUpdater\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests;
use Mithredate\FMSUpdater\Contracts\UpdateHandlerContract;

class UpdateController extends Controller
{
    public function index(UpdateHandlerContract $handler){
        $hasUpdate = $handler->checkForUpdates();
        return view('fms-updater::index', compact('hasUpdate'));
    }
    
    public function postUpdate(UpdateHandlerContract $handler){
        if($handler->checkForUpdates()){
            $handler->performUpdate();
        }
        return back();
    }
}
