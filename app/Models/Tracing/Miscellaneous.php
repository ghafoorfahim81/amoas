<?php

namespace App\Models\Tracing;

use Illuminate\Database\Eloquent\Model;

class Miscellaneous extends Model
{
    protected $table = 'traceable_miscellaneous';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid',
        'department_id',
        'doc_type',
        'noti_lang',
        'alt_email',
        'phone_no',
        'descriptions',
        'booking_id',
        'registrar_id',
        'price',
    ];

    protected $appends = ['title', 'lang'];

    public function trace()
    {
        return $this->morphOne('App\Models\Tracing\Document', 'traceable');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function getTitleAttribute()
    {
        return optional($this->type)->type;
    }

    public function getLangAttribute()
    {
        return $this->noti_lang;
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Tracing\MiscellaneousType', 'doc_type');
    }

    public function booking()
    {
        return $this->belongsTo('App\Booking', 'booking_id');
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }
}
