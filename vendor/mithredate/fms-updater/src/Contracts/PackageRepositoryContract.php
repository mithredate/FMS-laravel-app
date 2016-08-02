<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-08-02
 * Time: 3:43 AM
 */

namespace Mithredate\FMSUpdater\Contracts;


interface PackageRepositoryContract
{
    /**
     * @param $repository
     * @return string on success | boolean false on failure
     */
    public function getLatestCommitSHA($repository);

    /**
     * @param $source
     * @param $destination
     *
     * Stores the file located at source to destination
     */
    public function download($source, $destination);

    /**
     * @param $destination
     * @return boolean true on success | false on failure
     */
    public function extract($destination);
}