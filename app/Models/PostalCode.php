<?php

namespace App\Models;

use App\Country;
use App\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostalCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'zip',
        'place',
        'state',
        'country',
    ];

    // mission relation
    public function mission()
    {
        return $this->belongsTo(Department::class, 'mission_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
