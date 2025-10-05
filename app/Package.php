<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'title', 
        'description', 
        'price', 
        'category_id', 
        'photo_id', 
        'duration', 
        'daily_acceptance',
        'emergency_acceptance', 
        'config'
    ];

    protected $casts = [
        'config' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function departments()
    {
        return $this->belongsToMany('App\Department', 'department_package')
            ->withPivot('price', 'description', 'duration', 'daily_acceptance', 'emergency_acceptance');
    }

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }
}
