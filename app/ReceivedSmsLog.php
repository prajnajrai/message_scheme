<?php

namespace App;

use Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivedSmsLog extends Model
{
	use SoftDeletes;

    /**
     * Default dates in the table
     * @var array
     */
    protected $dates = ['received_time', 'created_at', 'updated_at', 'deleted_at'];
}