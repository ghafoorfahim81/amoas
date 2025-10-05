<?php

namespace App\Models\Tracing;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'traceable_docs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_id',
        'uid',
        'traceable_id',
        'traceable_type',
        'status',
        'is_public',
        'email',
        'applicant',
        'note',
        'registrar_id',
    ];

    public function traceable()
    {
        return $this->morphTo();
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public static function UID(\Illuminate\Http\Request $request, $depCode = 'AF-MFA')
    {
        // BONN-MA420-02001
        // $department = \App\Department::find(optional(auth()->user()->department)->id);

        // $depCode = $department ? $department->code : 'AF-MFA';

        // DB counter
        $counts = self::whereDate('created_at', '=', date('Y-m-d'))->count();

        $firstChars = array_map(function ($word) {
            return strtoupper(substr($word, 0, 1));
        }, explode(' ', $request->applicant));

        $firstChars = preg_match('/[^A-Za-z]/', implode('', $firstChars)) ? [] : $firstChars;

        $serialNo = $depCode.'-'.implode('', $firstChars).date('ny').'-'.date('j').sprintf('%03d', ++$counts);

        return $serialNo;

    }
}
