<?php

namespace App\Http\Controllers;

use App\Models\PostalCode;
use Illuminate\Http\Request;

class PostalCodeController extends Controller
{
    public function postalCodeList(Request $request)
    {
        $search = $request->input('q');
        $postalcodes = PostalCode::where('zip', 'LIKE', "{$search}%")
            ->take(15)
            ->get(['place', 'zip', 'state']);

        return response()->json($postalcodes);
    }
}
