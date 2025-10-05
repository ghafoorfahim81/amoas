<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionAddon extends Model
{
    protected $fillable = [
        'session_email', 'addon_id',
    ];

    public function addon()
    {
        return $this->belongsTo('App\Addon');
    }
}
