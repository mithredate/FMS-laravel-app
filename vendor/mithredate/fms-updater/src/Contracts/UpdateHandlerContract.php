<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-08-02
 * Time: 1:29 AM
 */

namespace Mithredate\FMSUpdater\Contracts;



interface UpdateHandlerContract
{
    public function checkForUpdates();

    public function performUpdate();
}