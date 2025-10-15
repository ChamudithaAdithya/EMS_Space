<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstanceTasksAssign extends Model
{
    use HasFactory;

    protected $table = 'instance_tasks_assign';

    protected $fillable = [
        'event_instance_task_id',
        'assigned_emp_id',
        'status',
    ];

    // Relationships (optional, for better Eloquent usage)
    public function assignedEmp()
    {
        return $this->belongsTo(AssignedEmployee::class, 'assigned_emp_id');
    }

    public function eventInstanceTask()
    {
        return $this->belongsTo(EventInstanceTask::class, 'event_instance_task_id');
    }
}
