<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $primaryKey = 'attendance_id';

    protected $fillable = [
        'member_id',
        'event_id',
        'admin_id',
        'attended_at',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Members::class, 'member_id', 'member_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }
}