<?php

namespace App\Models\Visa;

use Illuminate\Database\Eloquent\Model;

class VisaType extends Model
{
    protected $table = 'visa_types';

    protected $fillable = [
        'name',
        'label_en',
        'label_dr',
    ];
}
