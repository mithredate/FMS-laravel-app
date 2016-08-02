<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-08-02
 * Time: 1:28 AM
 */

namespace Mithredate\FMSUpdater;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Mithredate\FMSUpdater\Contracts\PackageRepositoryContract;
use Mithredate\FMSUpdater\Contracts\UpdateHandlerContract;
use Mithredate\FMSUpdater\Facades\Zip;
use Mithredate\FMSUpdater\Model\FMSUpdater;
/*
 * Handle FMS package update
 *
 * This class uses a configuration file to handle FMS package
 * update. Checks if a new update is available, and updates the
 * package from it's github repository.
 * */
class UpdateHandler implements UpdateHandlerContract
{

    /*
     * PackageRepositoryContract $repository
     *
     * Is instantiated through service container with gitPackageRepositoryBroker
     * */
    private $repository;


    /*
     * FMSUpdater $updater
     *
     * Holds the current FMS Updater object which includes
     * FMS package current hash
     *
     * This parameter, Hash, can be used to determine if a new update have been released
     * */
    private $updater;

    /*
     * string $lastHash
     *
     * Holds the latest hash retrieved from the package repository
     * */
    private $lastHash;

    /**
     * UpdateHandler constructor.
     * @param PackageRepositoryContract $repository
     */
    public function __construct(PackageRepositoryContract $repository)
    {
        $this->repository = $repository;
        $this->updater = FMSUpdater::first();
        $this->lastHash = $this->repository->getLatestCommitSHA(config('fms-updater.repository'));
    }


    /**
     * @return bool true if new update exists | false if otherwise
     */
    public function checkForUpdates()
    {
        return ($this->lastHash != $this->updater->hash);
    }

    /**
     * Downloads and extracts the new updates into the package directory
     *
     * also updates the last hash in database
     */
    public function performUpdate()
    {
        //Delegates package download to repository instance
        $this->repository->download(config('fms-updater.archive'), config('fms-updater.tmp'));

        //Delegates package extraction to it's repository instance
        $this->repository->extract(config('fms-updater.path'));

        //Update hash value with the latest hash from repository
        $this->updater->update(['hash' => $this->lastHash]);

        Session::push('fms-messages',['type' => 'success', 'message' => 'Update Successful']);

        //Delete the package archive
        unlink(config('fms-updater.tmp'));

    }

}