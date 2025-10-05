<?php

namespace App\Models\Tracing;

use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    protected $table = 'traceable_passports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid',
        'family_name',
        'given_name',
        'passport_no',
        'department_id',
        'status',
        'date',
    ];

    protected $appends = ['title'];

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
        return 'Passport';
    }
}
