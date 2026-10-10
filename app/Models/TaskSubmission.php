<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Fillable('task_id', 'dealer_id', 'google_drive_url', 'status', 'submitted_at', 'reviewed_at', 'reviewed_by')]
#[Table('task_submissions')]
class TaskSubmission extends Model
{
    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function logs()
    {
        return $this->hasMany(TaskActivityLog::class, 'task_submission_id')->latest('id');
    }
}
