<?php

Route::group(['middleware' => ['web','auth'],'prefix' => 'fms-updater', 'namespace' => 'Mithredate\\FMSUpdater\\Controllers'],function(){
    Route::get('update',['as' => 'fms-updater.index', 'uses' => 'UpdateController@index']);
    Route::post('update',['as' => 'fms-updater.update', 'uses' => 'UpdateController@postUpdate']);
});