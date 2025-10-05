<?php

namespace App\Models\Verification;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    protected $table = 'verifications';

    protected $fillable = [
        'department_id',
        'name',
        'last_name',
        'father_name',
        'grand_father_name',
        'birth_place',
        'marital_status',
        'living_duration',
        'living_duration_unit',
        'last_trip',
        'occupation',
        'contact_no',
        'email',
        'service_id',
        'new_absence_tazkira_case',
        'original_village',
        'original_district',
        'original_province',
        'current_city',
        'zip_code',
        'current_country',
        'height',
        'eyes',
        'skin',
        'hair',
        'other',
        'd_name',
        'd_last_name',
        'd_father_name',
        'd_contact',
        'sibling_name',
        'sibling_last_name',
        'sibling_father_name',
        'sibling_grand_father_name',
        'sibling_id',
        'page_no',
        'version_no',
        'note_no',
        'year',
        'month',
        'day',
        'registrar_id',
    ];

    public function province()
    {
        return $this->belongsTo('App\Province', 'original_province');
    }

    public function district()
    {
        return $this->belongsTo('App\District', 'original_district');
    }

    public function village()
    {
        return $this->belongsTo('App\Village', 'original_village');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function country()
    {
        return $this->belongsTo('App\Country', 'current_country');
    }

    public function image()
    {
        return $this->morphOne('App\Attachment', 'attachable');
    }

    public function sibling()
    {
        return $this->belongsTo('App\Models\Verification\Sibling', 'sibling_id');
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Verification\Service', 'service_id');
    }
}
