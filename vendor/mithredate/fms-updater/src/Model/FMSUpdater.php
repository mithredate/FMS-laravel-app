<?php

namespace Mithredate\FMSUpdater\Model;

use Illuminate\Database\Eloquent\Model;

class FMSUpdater extends Model
{
    public $table = 'fms_updater';

    public $timestamps = false;

    protected $guarded = ['id'];
}
