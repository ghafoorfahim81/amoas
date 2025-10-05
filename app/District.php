<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    public $timestamps = false;

    protected $fillable = [
        'code',
        'name_en',
        'name_dr',
    ];
}
