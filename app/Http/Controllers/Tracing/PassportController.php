<?php

namespace App\Http\Controllers\Tracing;

use App\Http\Controllers\Controller;
use App\Imports\ImpPassportTracing;
use App\Models\Tracing\Passport;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PassportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:passport show'])->only(['index', 'show']);
        $this->middleware(['permission:passport import'])->only(['store', 'import']);
        $this->middleware(['permission:passport delete'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tracing.passport.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->exists('import')) {
            return $this->storeImports($request);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeImports(Request $request)
    {
        $this->validate($request, [
            'department_id' => 'required',
            'note' => 'nullable|max:254',
            'excel_file' => 'required',
        ]);

        // Import to Array
        $passportsArr = \Excel::toArray(new ImpPassportTracing, request()->file('excel_file'));

        // session(['totalCount' => 0, 'progressCount' => 0]);

        if (array_key_exists(0, $passportsArr)) {
            \App\Jobs\ImportPassportTracingExcel::dispatch($passportsArr[0], $request->except(['excel_file', '_token']));
        }

        return redirect(route('passport.index'))
            ->with(['alert' => 'Excel imported successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Import the specified resource from excel file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        return view('tracing.passport.import');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataTable()
    {
        $passports = Passport::with(['department:id,name_en']);

        return Datatables::of($passports)
            ->addColumn('action', function ($passport) {
                $action = '<a href="'.route('passport.show', $passport->id).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>&nbsp;';

                // $action .= '<a href="' . route('bookings.edit', $booking->id) .'" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>';
                return $action;
            })
            ->make(true);
    }

    public function impProgressStatus()
    {
        return response()->json([
            'status' => session('progressCount') > 0 ? 'Importing Excel' : 'Uploading File',
            'importedCount' => session('progressCount'),
            'importedTotalCount' => session('totalCount'),
        ]);
    }
}
