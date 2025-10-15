<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedEmployee extends Model
{
    use HasFactory;
    public $timestamps =true;
    public $table = "assigned_emp";
    protected $fillable = ['task_id','emp_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function event_instance_tasks()
    {
        return $this->hasMany(EventInstanceTask::class);
    }

}


