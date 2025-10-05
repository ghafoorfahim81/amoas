<?php

namespace App\Models\Tracing;

use Illuminate\Database\Eloquent\Model;

class MiscellaneousType extends Model
{
    protected $table = 'miscellaneous_type';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
    ];

    public function miscs()
    {
        return $this->hasMany('App\Models\Tracing\Miscellaneous', 'doc_type');
    }
}
