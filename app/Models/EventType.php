<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{

    use HasFactory;

    protected $fillable = [
        'event_type',
        'img_path'
    ];


    public function event_types(){
        return $this->hasMany(NewEvent::class,'event_type_id', 'id');
    }


    public function annual_events(){
        return $this->hasMany(NewEvent::class,'event_type_id', 'id');
    }

    public function tasks(){
        return $this->hasMany(Task::class,'event_type_id', 'id');
    }
}
