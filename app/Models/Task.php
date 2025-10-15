<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_name',
        'event_type_id'
    ];

    public function attachments(){
        return $this->hasMany(Attachment::class, 'task_id');
    }

    public function task_instances(){
        return $this->hasMany(EventInstanceTask::class, 'tasks_id');
    }
}
