<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
#[Fillable('title', 'department_id', 'area_id', 'due_at', 'created_by')]
#[Table('tasks')]

class Task extends Model
{
    //
}
