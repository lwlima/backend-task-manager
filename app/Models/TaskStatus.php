<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskStatus extends Model
{
    use SoftDeletes;

    /**
     * 
     * 
     * @var string
     */
    protected $table = 'task_status';

    /**
     * The attributes that are mass assignable.
     * 
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug_name',
    ];
}
