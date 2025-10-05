<?php

namespace App\Models\Verification;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'name', 'label_en', 'label_dr',
    ];
}
