<?php

namespace App\Models\Tasaadiq;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class MarriageCertificate extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'marriage_certificates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial_no',
        'issue_date',
        'print_type',
        'dom',
        'pom',
        'husband_family_name',
        'husband_given_name',
        'husband_previous_name',
        'husband_passport_no',
        'husband_dob',
        'husband_pob',
        'wife_family_name',
        'wife_given_name',
        'wife_previous_name',
        'wife_passport_no',
        'wife_dob',
        'wife_pob',
        'department_id',
        'registrar_id',
    ];

    protected static $logFillable = true;

    protected static $logName = 'Marraige Certificate';

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
        // $dayCounts = self::whereDate('created_at', '=', date('Y-m-d'))->count();

        // fixed counter
        $fixedCounter = 390;

        $serialNo = 'MC'.date('y').'-'.($counts + $fixedCounter);
        // check if exists
        while (self::where('serial_no', $serialNo)->exists()) {
            $serialNo = 'MC'.date('y').'-'.($counts + $fixedCounter++);
        }

        return $serialNo;

        // $counts = self::count();
        // $dayCounts = self::whereDate('created_at', '=', date('Y-m-d'))->count();

        // return 'MC' . date('ymd') . sprintf('%02d', $dayCounts + 1) . sprintf('%03d', $counts + 1);
    }
}
