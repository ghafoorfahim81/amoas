<?php

namespace App\Models\Visa;

use App\Scopes\DepartmentScope;
use Illuminate\Database\Eloquent\Model;

class VisaForm extends Model
{
    protected $table = 'visa_form';

    protected $fillable = [
        'department_id',
        'serial_no',
        'title',
        'family_name',
        'given_name',
        'father_name',
        'dob',
        'birth_country',
        'marital_status',
        'gender',
        'residence_country',
        'nationality',
        'other_nationality',
        'under_18',
        'address',
        'email',
        'mobile',
        'occupation',
        'employer_name',
        'employer_address',
        'pre_employer_name',
        'status',
        'pre_employer_address',
        'visa_type',
        'purpose',
        'entry_date',
        'intend_duration',
        'entry_point',
        'children_no',
        'visit_places',
        'af_address',
        'visited_before',
        'applied_visa',
        'criminal_record',
        'passport_type',
        'passport_no',
        'issue_place',
        'issue_date',
        'expire_date',
        'photo',
        'registrar_id',
    ];

    protected $casts = [
        'under_18' => 'boolean',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DepartmentScope);
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function country()
    {
        return $this->belongsTo('App\Country', 'residence_country');
    }

    public function birthCountry()
    {
        return $this->belongsTo('App\Country', 'birth_country');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Visa\VisaType', 'visa_type');
    }

    public function image()
    {
        return $this->morphOne('App\Attachment', 'attachable');
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }

    public static function generateSerialNo($departmentId)
    {
        // get count of today's record
        $counts = self::count();

        $department = \App\Department::find($departmentId) ? \App\Department::find($departmentId)->code : 'AFG';

        $serialNo = date('ynj').'-'.$department.'-'.sprintf('%04d', ++$counts);

        return $serialNo;
        // return sprintf('%04d', 2565426);
    }

    public static function getPackageId()
    {
        $package = \App\Package::select(['id', 'title'])->whereRaw("lower(title) REGEXP 'visa|ویزا'")->first();

        return $package->id;
    }
}
