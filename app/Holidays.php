<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holidays extends Model
{
    protected $appends = [
        'date',
        'repeated_date',
        'next_year_repeated_date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day',
        'month',
        'year',
        'repeated',
        'description',
    ];

    protected $casts = [
        'repeated' => 'boolean',
    ];

    public function departments()
    {
        return $this->belongsToMany('App\Department', 'department_holidays');
    }

    /**
     * Get the date.
     *
     * @return string
     */
    public function getDateAttribute()
    {
        return $this->year . '-' . sprintf('%02d', $this->month) . '-' . sprintf('%02d', $this->day);
    }

    public function getRepeatedDateAttribute()
    {
        $thisYear = date('Y');
        return $this->repeated ? $thisYear . '-' . sprintf('%02d', $this->month) . '-' . sprintf('%02d', $this->day) : null;
    }

    public function getNextYearRepeatedDateAttribute()
    {
        $thisYear = date('Y');
        $nextYearDate = ($thisYear + 1) . '-' . sprintf('%02d', $this->month) . '-' . sprintf('%02d', $this->day);

        return $this->repeated ? $nextYearDate : null;
    }
}
