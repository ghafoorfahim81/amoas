<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function ajax()
    {
        // return request()->all();
        if (request()->ajax()) {

            if (request()->has('t')) {
                $query = \DB::table(request()->t);
                $query->select(request()->f);
                foreach (request()->s as $key => $field) {
                    if ($key == 0) {
                        $query->where($field, 'like', '%'.request()->term.'%');

                        continue;
                    }
                    $query->orWhere($field, 'like', '%'.request()->term.'%');
                }
                $result = $query->get();

                return $result->toJson();
            }
        }

        return abort(403);
    }
}
