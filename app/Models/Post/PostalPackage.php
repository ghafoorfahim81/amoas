<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PostalPackage extends Model
{
    use LogsActivity;

    protected $table = 'postal_packages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'email',
        'phone',
        'uid',
        'status',
        'post',
        'registrar_id',
        'department_id',
        'place',
        'date',
        'description',
        'street',
        'house_no',
        'post_price',
        'doc_price',
        'booking_id',
    ];

    protected $appends = ['total'];

    protected static $logFillable = true;

    protected static $logName = 'Postal Package';

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logOnlyDirty = true;
    // protected static $submitEmptyLogs = false;

    public function passports()
    {
        return $this->morphedByMany('App\Models\Tracing\Passport', 'postable', 'post', 'postal_id');
    }

    public function miscs()
    {
        return $this->morphedByMany('App\Models\Tracing\Miscellaneous', 'postable', 'post', 'postal_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }

    public function getTotalAttribute()
    {
        return optional($this->passports())->count() + optional($this->miscs())->count();
    }

    public function deliverables()
    {
        return $this->hasMany('App\Models\Post\DeliverableDoc', 'postal_id');
    }

    public function booking()
    {
        return $this->belongsTo('App\Booking', 'booking_id');
    }

    public function checklists()
    {
        return $this->belongsToMany('App\Models\Post\PostCheckList', 'checklist_post_pivot', 'checklist_id', 'post_id');
    }

    /**
     * add custom field to activity log
     *
     * @param  activity  $var  Description
     * @param  eventName  $var  Description
     **/
    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = $activity
            ->properties
            ->put('checklists', $this->checklists()->pluck('name')->toArray());
        $activity->properties = $activity
            ->properties
            ->put('deliverables', $this->deliverables()->pluck('name')->toArray());
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Postal Package\'s Logs')
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->dontSubmitEmptyLogs();
    }
}
