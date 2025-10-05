<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class BookingInfo extends Model
{
    protected $table = 'booking_info';

    protected $fillable = [
        'booking_id',
        'full_name',
        'email',
        'phone',
        'id_card',
        'postal',
        'address',
        'city',
        'state',
    ];

    protected $appends = [
        'full_address',
    ];

    protected $casts = [
        // 'under_18' => 'boolean',
    ];

    public function booking()
    {
        return $this->hasOne('App\Booking', 'booking_id');
    }

    public function participants()
    {
        return $this->hasMany('App\Models\Booking\Participant', 'info_id');
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->postal}, {$this->city}, {$this->state}";
    }
}
