<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'password',
        'role',
        'member_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function member()
    {
        return $this->belongsTo(Members::class, 'member_id', 'member_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'admin_id', 'admin_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'admin_id', 'admin_id');
    }
}