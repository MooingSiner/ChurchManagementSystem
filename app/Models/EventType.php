<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $table = 'types';
    protected $primaryKey = 'type_id';
    public $timestamps = false;

    protected $fillable = [
        'type_name',
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'type_id', 'type_id');
    }
}