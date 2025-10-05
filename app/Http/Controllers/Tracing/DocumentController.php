<?php

namespace App\Http\Controllers\Tracing;

use App\Http\Controllers\Controller;
use App\Models\Tracing\Document;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:docs show'])->only(['index', 'show']);
        // $this->middleware(['permission:docs create'])->only(['create', 'store']);
        // $this->middleware(['permission:booking delete'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tracing.docs.index');
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
        //
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
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataTable()
    {
        $docs = Document::with(['traceable']);

        return Datatables::of($docs)
            ->addColumn('is_public', function ($doc) {
                $action = $doc->is_public == 1 ? '<span class="badge badge-info">Yes</span>' : '<span class="badge badge-dark">No</span>';

                return $action;
            })
            ->rawColumns(['is_public'])
            ->make(true);
    }

    /**
     * check the status of a document
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkStatus()
    {
        $message = null;
        $docs = null;
        if (strlen(request()->uid) < 5) {
            $message = ! request()->filled('uid') ? null : __('validation.min.string', ['min' => 5, 'attribute' => 'Unique ID']);
        } else {
            $docs = Document::where('uid', request()->uid)
                ->where('is_public', 1)
                ->with(['traceable'])
                ->get();

            if ($docs) {
                $docs = $docs->map(function ($item, $key) {
                    if (optional($item->traceable)->noti_lang == 'dr') {
                        $item->setAttribute('dep_name', optional($item->department)->name_dr);
                    } elseif (optional($item->traceable)->noti_lang == 'ps') {
                        $item->setAttribute('dep_name', optional($item->department)->name_pa);
                    } else {
                        $item->setAttribute('dep_name', optional($item->department)->name_en);
                    }

                    return $item;
                });
            }
        }

        return view('tracing.docs.check-status', compact('message', 'docs'));
    }
}
