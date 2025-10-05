<?php

namespace App;

use App\Scopes\DepartmentScope;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'package_id', 'department_id', 'serial_no', 'booking_date',
        'booking_time', 'google_calendar_event_id', 'email', 'booking_type', 'status',
    ];

    public function invoice()
    {
        return $this->hasOne('App\Invoice');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function info()
    {
        return $this->hasOne('App\Models\Booking\BookingInfo', 'booking_id');
    }

    public function package()
    {
        return $this->belongsTo('App\Package');
    }

    public function addons()
    {
        return $this->belongsToMany('App\Addon')->withTimestamps();
    }

    public function cancel_request()
    {
        return $this->hasOne('App\CancelRequest');
    }

    public function miscs()
    {
        return $this->hasMany('App\Models\Tracing\Miscellaneous');
    }

    public function postalPackage()
    {
        return $this->hasMany('App\Models\Post\PostalPackage');
    }

    public static function genSerialNo($departmentId, $packageId)
    {
        $counts = self::whereDate('created_at', '=', date('Y-m-d'))->count();

        $department = Department::find($departmentId);

        // $serialNo = $department.'-'.date('ynj').'-'.sprintf('%03d', ++$counts);
        $serialNo = "{$department->code}{$packageId}" . date('ynj') . sprintf('%03d', ++$counts);

        return $serialNo;
    }
}
