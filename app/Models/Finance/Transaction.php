<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends Model
{
    use LogsActivity, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'amount',
        'currency',
        'registrar_id',
    ];

    protected static $logFillable = true;

    protected static $logName = 'Transaction Log';

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    /**
     * Get the owning accountable model.
     */
    public function accountable()
    {
        return $this->morphTo();
    }
}
