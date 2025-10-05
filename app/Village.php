<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $table = 'village';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'name_en',
        'name_dr',
    ];
}
