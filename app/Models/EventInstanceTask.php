<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventInstanceTask extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'tasks_id',
        'new_event_id',
        'status',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'tasks_id', 'id');
    }

    public function taskassign()
    {
        return $this->hasMany(InstanceTasksAssign::class, 'id', 'event_instance_task_id');
    }

    public function assigned_employees()
    {
        return $this->belongsTo(Employee::class, 'emp_assign', 'emp_id');
    }
}
