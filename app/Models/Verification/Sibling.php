<?php

namespace App\Models\Verification;

use Illuminate\Database\Eloquent\Model;

class Sibling extends Model
{
    protected $fillable = [
        'name', 'label_en', 'label_dr',
    ];
}
