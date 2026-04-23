<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $table = 'members';
    protected $primaryKey = 'member_id';

    protected $fillable = [
        'member_fname',
        'member_mname',
        'member_lname',
        'gender',
        'birth_date',
        'email',
        'phone_number',
    ];

    public function address()
    {
        return $this->hasOne(Address::class, 'member_id', 'member_id');
    }

    public function ministries()
    {
        return $this->belongsToMany(
            Ministry::class,
            'members_ministries',
            'member_id',
            'ministry_id'
        );
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'member_id', 'member_id');
    }
}