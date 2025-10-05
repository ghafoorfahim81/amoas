<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Receipt extends Model
{
    use LogsActivity, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'receipt_no',
        'date',
        'client_name',
        'id_card',
        'service_id',
        'received_by',
        'accountant_id',
        'clearance_id',
        'registrar_id',
        'payment_method',
        'bill_no',
        'quantity',
        'remarks',
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];

    protected $appends = ['transaction_no'];

    protected static $logFillable = true;

    protected static $logName = 'Receipt Log';

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('accountant', function (Builder $builder) {
            if (auth()->user()->isSuperAdmin()) {
            } elseif (auth()->user()->hasPermissionTo('finance admin')) {
            } else {
                $builder->where('accountant_id', auth()->id());
            }
        });

        // static::addGlobalScope('cleared', function (Builder $builder) {
        //     $builder->whereNull('clearance_id');
        // });

    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'accountable');
    }

    public function service()
    {
        return $this->belongsTo(PaymentService::class);
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }

    public static function generateSerialNo()
    {
        $dayCounts = self::whereDate('created_at', '=', date('Y-m-d'))->count();

        $userAbrrv = substr(auth()->user()->first_name, 0, 1).substr(auth()->user()->last_name, 0, 1);

        return date('ymd').$userAbrrv.sprintf('%03d', $dayCounts + 1);
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getTransactionNoAttribute()
    {
        return sprintf('%08d', optional($this->transaction)->id);
    }

    /**
     * Scope a query to only get the uncleared transcation.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCleared($query)
    {
        return $query->whereNull('clearance_id');
    }
}
