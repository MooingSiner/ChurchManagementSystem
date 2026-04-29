<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'event_id';

    protected $fillable = [
        'event_name',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'description',
        'type_id',
        'admin_id',
        'status',
    ];

    public function type()
    {
        return $this->belongsTo(EventType::class, 'type_id', 'type_id');
    }

    public function admin()
    {
        return $this->belongsTo(Administrator::class, 'admin_id', 'admin_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'event_id', 'event_id');
    }

    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class, 'event_id', 'event_id');
    }
}
