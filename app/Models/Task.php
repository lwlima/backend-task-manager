<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'tasks';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'status_id',
        'title',
        'description',
        'started_at',
        'finished_at',
        'worked_hours'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }
}
