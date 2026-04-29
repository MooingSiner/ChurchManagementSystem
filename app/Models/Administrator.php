<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrator extends Authenticatable
{
    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $appends = [
        'role_label',
    ];

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'super_admin' => 'Church Administrator',
            'admin' => 'Attendance Coordinator',
            default => 'Administrator',
        };
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'admin_id', 'admin_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'admin_id', 'admin_id');
    }

    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class, 'admin_id', 'admin_id');
    }
}
