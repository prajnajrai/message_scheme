<?php

namespace App;

use Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SentSmsLog extends Model
{
	use SoftDeletes;

    /**
     * Default dates in the table
     * @var array
     */
    protected $dates = ['sent_time', 'created_at', 'updated_at', 'deleted_at'];
}