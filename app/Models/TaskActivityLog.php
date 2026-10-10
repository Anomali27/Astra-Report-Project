<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Fillable('task_submission_id', 'user_id', 'activity', 'note')]
#[Table('task_activity_log')]
class TaskActivityLog extends Model
{
    //
}
