<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;


#[Fillable('task_id', 'dealer_id', 'google_drive_url', 'status', 'submitted_at', 'reviewed_at', 'reviewed_by' )]
#[Table('task_submissions')]
class TaskSubmission extends Model
{
    //
}
