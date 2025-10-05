<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name_en',
        'name_dr',
        'name_pa',
        'parent_id',
        'user_id',
        'type',
        'code',
    ];

    protected $appends = ['title_abbr_str_en', 'title_abbr_str_dr'];

    protected static $logAttributes = ['*'];

    protected static $logName = 'Department\'s Logs';

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function settings()
    {
        return $this->belongsToMany(Settings::class, 'department_setting');
    }

    public function setting()
    {
        return $this->setting()->first();
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'department_package')
            ->withPivot('price', 'description', 'duration', 'daily_acceptance', 'emergency_acceptance');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id')->with('children');
    }

    public function hasChildren()
    {
        return $this->children->count() > 0 ? true : false;
    }

    public static function printTree($child)
    {
        $tree = app()->isLocale('en') ? '<li>' . $child->name_en : '<li>' . $child->name_dr;

        if ($child->hasChildren()) {
            $tree .= '<ul>';
            foreach ($child->children as $desecent) {
                $tree .= self::printTree($desecent);
            }
            $tree .= '</ul>';
        }

        return $tree .= '</li>';
    }

    public static function getDepartmentByType($type = 'directorate')
    {
        return Department::where('type', $type)->get();
    }

    public static function subDepartmentsArray(Department $department)
    {
        $dep = [];
        if ($department->hasChildren()) {
            foreach ($department->children as $desecent) {
                array_push($dep, $desecent);
            }
        }

        return $dep;
    }

    public static function subDepartments(Department $department)
    {
        return new Collection(self::subDepartmentsArray($department));
    }

    public function generateCode()
    {
        $prefix = '';
        $stringIndexPosition = 0;

        if ($this->type == 'consulate') {
            $prefix = 'C';
            $stringIndexPosition = 56;
        }
        if ($this->type == 'embassy') {
            $prefix = 'E';
            $stringIndexPosition = 45;
        }

        $full = trim(substr($this->name_en, $stringIndexPosition));
        $tokenized = explode(' ', $full);

        if (count($tokenized) == 1) {
            $this->code = $prefix . strtoupper(substr($full, 0, 4));
        }

        if (count($tokenized) == 2) {
            $token = '';
            foreach ($tokenized as $t) {
                $token .= strtoupper(substr($t, 0, 3));
            }
            $this->code = $prefix . $token;
        }

        if (count($tokenized) > 2) {
            $token = '';
            foreach ($tokenized as $t) {
                if (in_array($t, ['in', 'at', 'and', 'of'])) {
                    continue;
                }
                $token .= strtoupper(substr($t, 0, 2));
            }
            $this->code = $prefix . $token;
        }

        $this->save();

        return $this->code;
    }

    public function getTitleAbbrStrEnAttribute()
    {
        if ($this->type == 'consulate' || $this->type == 'embassy')
            return str_replace(["Embassy of the Islamic Republic of Afghanistan ", "Consulate General of the Islamic Republic of Afghanistan "], '', $this->name_en);
    }

    public function getTitleAbbrStrDrAttribute()
    {
        if ($this->type == 'consulate' || $this->type == 'embassy')
            return str_replace(['سفارت جمهوری اسلامی افغانستان', 'جنرال قونسلگری جمهوری اسلامی افغانستان'], '', $this->name_dr);
    }
}
