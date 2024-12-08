<?php

namespace App\Models;

use App\Notifications\TaskNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'assigned_to_id',
        'assigned_by_id',
        'due_date',
        'status',
        'title',
        'status',
        'due_date'
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected static function booted()
    {
        // Notification when task is created and assigned
        static::created(function ($task) {
            if ($task->assignedTo) {
                $task->assignedTo->notify(
                    new TaskNotification($task, 'assigned')
                );
            }
        });

        // Notification when task status is updated
        static::updated(function ($task) {
            if ($task->wasChanged('status') && $task->assignedTo) {
                $task->assignedTo->notify(
                    new TaskNotification($task, 'status_updated')
                );
            }
        });
    }
}
