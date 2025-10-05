<?php

namespace App\Models\Finance;

use App\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Clearance extends Model
{
    use LogsActivity, SoftDeletes;

    protected $table = 'clearance';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'receiver_account',
        'deliver_account',
        'clear_from',
        'clear_to',
        'remarks',
        'registrar_id',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'clear_from' => 'date:Y-m-d',
        'clear_to' => 'date:Y-m-d',
    ];

    protected static $logFillable = true;

    protected static $logName = 'Clearance Log';

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    public function receipts()
    {
        return $this->hasMany(Receipt::class, 'clearance_id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User', 'receiver_account');
    }

    public function deliver()
    {
        return $this->belongsTo('App\User', 'deliver_account');
    }

    public function attachments()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }
}
