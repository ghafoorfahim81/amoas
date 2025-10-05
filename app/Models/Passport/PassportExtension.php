<?php

namespace App\Models\Passport;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PassportExtension extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'passport_extensions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pass_no',
        'given_name',
        'last_name',
        'status',
        'postal_code',
        'place',
        'street',
        'house_no',
        'phone',
        'invoice_no',
        'family_id',
        'remarks',
        'registrar_id',
    ];

    protected static $logFillable = true;

    protected static $logName = 'Passport Extensions';

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logOnlyDirty = true;

    public function members()
    {
        return $this->hasMany(self::class, 'family_id');
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }
}
