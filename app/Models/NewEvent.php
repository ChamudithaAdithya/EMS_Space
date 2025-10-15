<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewEvent extends Model
{
    use HasFactory;

    protected $table = 'new_event';

    public $timestamps = true;

    protected $fillable = [
        'event_type_id',
        'event_name',
        'start_date',
        'end_date',
        'coordinator',
        'active_status'
    ];

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function tasks()
    {
        return $this->hasMany(EventInstanceTask::class);
    }
}
