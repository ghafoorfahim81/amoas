<?php

namespace App\Models\Tasaadiq;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class CelibacyCertificate extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'celibacy_certificates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial_no',
        'issue_date',
        'family_name',
        'given_name',
        'print_type',
        'sex',
        'dob',
        'pob',
        'passport_no',
        'department_id',
        'registrar_id',
    ];

    protected static $logFillable = true;

    protected static $logName = 'Celibacy Certificate';

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logOnlyDirty = true;

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }

    public static function generateSerialNo()
    {
        $counts = self::count();

        // fixed counter
        $fixedCounter = 164;

        $serialNo = 'CC'.date('y').'-'.($counts + $fixedCounter);

        // check if exists
        while (self::where('serial_no', $serialNo)->exists()) {
            $serialNo = 'CC'.date('y').'-'.($counts + $fixedCounter++);
        }

        return $serialNo;

        // $counts = self::count();
        // $dayCounts = self::whereDate('created_at', '=', date('Y-m-d'))->count();
        // return 'CC' . date('ymd') . sprintf('%02d', $dayCounts + 1) . sprintf('%03d', $counts + 1);
    }
}
