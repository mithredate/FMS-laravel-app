<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-08-02
 * Time: 3:44 AM
 */

namespace Mithredate\FMSUpdater;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Mithredate\FMSUpdater\Contracts\PackageRepositoryContract;
use Mithredate\FMSUpdater\Facades\Zip;

class GitPackageRepositoryBroker implements PackageRepositoryContract
{

    public function getLatestCommitSHA($repository)
    {

        $ch = curl_init($repository);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //disable ssl verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //set user agent
        curl_setopt($ch,CURLOPT_USERAGENT,Auth::user() . ' FMS updater');

        // $output contains the output string
        $output = curl_exec($ch);


        if(!$output){
            die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
        }

        // close curl resource to free up system resources
        curl_close($ch);

        //check if the response contains a valid JSON
        $valid_json = json_decode($output);

        if(! $valid_json ){
            Session::push('fms-message',['type' => 'danger', 'message' => 'Invalid JSON returned from ' . $repository]);
            return false;
        }

        if( ! is_array($valid_json) || count($valid_json) == 0){
            Session::push('fms-message',['type' => 'danger', 'message' => 'Invalid data structure returned from ' . $repository]);
            return false;
        }

        return $valid_json[0]->sha;
    }

    public function download($source, $destination)
    {
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        file_put_contents($destination, file_get_contents($source,false, stream_context_create($arrContextOptions)));
    }

    public function extract($destination)
    {
        try {
            //Checks if the archive can be opened
            $temp = $destination . '/FMS-master';
            if(Zip::open(config('fms-updater.tmp'))) {
                Zip::extractTo($destination);
                File::copyDirectory($temp, $destination, true);
                File::deleteDirectory($temp);
                Zip::close();
                return true;
            }
            Session::push('fms-messages',['type' => 'danger', 'message' => 'Unable to open package archive']);
            return false;
        } catch (\Exception $e){
            Session::push('fms-messages',['type' => 'danger', 'message' => $e->getMessage()]);
            return false;
        }
    }
}