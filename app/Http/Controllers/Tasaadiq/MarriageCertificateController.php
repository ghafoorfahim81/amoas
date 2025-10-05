<?php

namespace App\Http\Controllers\Tasaadiq;

use App\Http\Controllers\Controller;
use App\Models\Tasaadiq\MarriageCertificate;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class MarriageCertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:marriage certificate show'])->only(['index', 'show']);
        $this->middleware(['permission:marriage certificate create'])->only(['create', 'store']);
        $this->middleware(['permission:marriage certificate edit'])->only(['edit', 'update']);
        $this->middleware(['permission:marriage certificate delete'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tasaadiq.marriage.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasaadiq.marriage.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'husband_family_name' => 'required',
            'husband_given_name' => 'required',
            'husband_dob' => 'required',
            'husband_pob' => 'required_without:husband_pob_outside',
            'husband_pob_outside' => 'required_without:husband_pob',
            'husband_passport_no' => 'required',

            'wife_family_name' => 'required',
            'wife_given_name' => 'required',
            'wife_dob' => 'required',
            'wife_pob' => 'required_without:wife_pob_outside',
            'wife_pob_outside' => 'required_without:wife_pob',
            'wife_passport_no' => 'required',

            'pom' => 'required',
            'dom' => 'required',
        ]);

        \DB::beginTransaction();
        try {
            $serialNo = MarriageCertificate::generateSerialNo();

            $newMC = MarriageCertificate::create([
                'husband_family_name' => strtoupper($request->husband_family_name),
                'husband_given_name' => strtoupper($request->husband_given_name),
                'husband_previous_name' => strtoupper($request->husband_previous_name),
                'husband_dob' => $request->husband_dob,
                'husband_pob' => $request->filled('husband_pob_outside') ? strtoupper($request->husband_pob_outside) : strtoupper($request->husband_pob),
                'husband_passport_no' => strtoupper($request->husband_passport_no),

                'wife_family_name' => strtoupper($request->wife_family_name),
                'wife_given_name' => strtoupper($request->wife_given_name),
                'wife_previous_name' => strtoupper($request->wife_previous_name),
                'wife_dob' => $request->wife_dob,
                'wife_pob' => $request->filled('wife_pob_outside') ? strtoupper($request->wife_pob_outside) : strtoupper($request->wife_pob),
                'wife_passport_no' => strtoupper($request->wife_passport_no),

                'pom' => strtoupper($request->pom),
                'dom' => $request->dom,

                'serial_no' => $serialNo,
                'print_type' => 'new',
                'issue_date' => date('Y-m-d'),
                'department_id' => auth()->user()->department_id,
                'registrar_id' => auth()->id(),
            ]);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }

        return redirect()->route('marriage.show', [$newMC])->with(['print' => true]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MarriageCertificate $marriage)
    {
        return view('tasaadiq.marriage.show', compact('marriage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MarriageCertificate $marriage)
    {
        return view('tasaadiq.marriage.edit', compact('marriage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MarriageCertificate $marriage)
    {
        $this->validate($request, [
            'husband_family_name' => 'required',
            'husband_given_name' => 'required',
            'husband_dob' => 'required',
            'husband_pob' => 'required_without:husband_pob_outside',
            'husband_pob_outside' => 'required_without:husband_pob',
            'husband_passport_no' => 'required',

            'wife_family_name' => 'required',
            'wife_given_name' => 'required',
            'wife_dob' => 'required',
            'wife_pob' => 'required_without:wife_pob_outside',
            'wife_pob_outside' => 'required_without:wife_pob',
            'wife_passport_no' => 'required',

            'pom' => 'required',
            'dom' => 'required',
        ]);

        \DB::beginTransaction();
        try {

            $marriage->update([
                'husband_family_name' => strtoupper($request->husband_family_name),
                'husband_given_name' => strtoupper($request->husband_given_name),
                'husband_previous_name' => strtoupper($request->husband_previous_name),
                'husband_dob' => $request->husband_dob,
                'husband_pob' => $request->filled('husband_pob_outside') ? strtoupper($request->husband_pob_outside) : strtoupper($request->husband_pob),
                'husband_passport_no' => strtoupper($request->husband_passport_no),

                'wife_family_name' => strtoupper($request->wife_family_name),
                'wife_given_name' => strtoupper($request->wife_given_name),
                'wife_previous_name' => strtoupper($request->wife_previous_name),
                'wife_dob' => $request->wife_dob,
                'wife_pob' => $request->filled('wife_pob_outside') ? strtoupper($request->wife_pob_outside) : strtoupper($request->wife_pob),
                'wife_passport_no' => strtoupper($request->wife_passport_no),

                'pom' => strtoupper($request->pom),
                'dom' => $request->dom,
            ]);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }

        return redirect()->route('marriage.show', [$marriage->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MarriageCertificate $marriage)
    {
        $marriage->delete();

        return redirect()->route('marriage.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataTable()
    {
        $marriages = MarriageCertificate::with(['registrar:id,last_name'])->select('marriage_certificates.*');

        if (! request()->order) {
            $marriages->latest();
        }

        return datatables()::of($marriages)
            ->addColumn('action', function ($marriage) {
                $action = '<a href="'.route('marriage.show', $marriage->id).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>&nbsp;';

                // $action .= '<a href="' . route('bookings.edit', $booking->id) .'" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>';
                return $action;
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function print(MarriageCertificate $marriage)
    {
        if ($marriage->print_type == 'new') {
            return $this->newPrint($marriage);
        }

        return $this->oldPrint($marriage);
    }

    public function newPrint(MarriageCertificate $marriage)
    {
        $tempName = 'templates/marriage_certificate_new_update.pdf';

        try {

            $pom = strpos($marriage->pom, '/') ? $marriage->pom : $marriage->pom.'/AFG';

            ob_clean();
            header('Content-type: application/pdf');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            $defaultConfig = (new \Mpdf\Config\ConfigVariables)->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new \Mpdf\Config\FontVariables)->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new Mpdf([
                'fontDir' => array_merge($fontDirs, [
                    public_path().'/fonts',
                ]),
                'fontdata' => $fontData + [
                    'biosans' => [
                        'R' => 'biosans_r.ttf',
                        'B' => 'biosans_b.ttf',
                        'I' => 'biosans_i.ttf',
                    ],
                ],
                'default_font' => 'biosans',
            ]);

            $pagecount = $mpdf->SetSourceFile($tempName);
            $tplIdx = $mpdf->ImportPage($pagecount);
            $mpdf->UseTemplate($tplIdx);

            $mpdf->SetFont('biosans', 'B', 13);
            $mpdf->WriteText(42, 76, $marriage->serial_no.' ');

            $issueDate = Carbon::parse($marriage->issue_date.' ');

            $mpdf->WriteText(42, 89.5, $issueDate->format('d.m.Y'));

            $mpdf->SetFont('biosans', 'R', 13);
            $mpdf->WriteText(25, 142, $marriage->husband_family_name.' ');
            $mpdf->WriteText(108, 142, $marriage->wife_family_name.' ');

            $mpdf->WriteText(25, 156.5, $marriage->husband_given_name.' ');
            $mpdf->WriteText(108, 156.5, $marriage->wife_given_name.' ');

            $mpdf->WriteText(25, 171, $marriage->husband_previous_name.' ');
            $mpdf->WriteText(108, 171, $marriage->wife_previous_name.' ');

            $hDob = Carbon::parse($marriage->husband_dob);
            $wDob = Carbon::parse($marriage->wife_dob);
            $mpdf->WriteText(25, 185.5, $hDob->format('d.m.Y').' ');
            $mpdf->WriteText(108, 185.5, $wDob->format('d.m.Y').' ');

            $hPob = strpos($marriage->husband_pob, '/') ? $marriage->husband_pob : $marriage->husband_pob.'/AFG';
            $wPob = strpos($marriage->wife_pob, '/') ? $marriage->wife_pob : $marriage->wife_pob.'/AFG';
            $mpdf->WriteText(25, 200, $hPob.' ');
            $mpdf->WriteText(108, 200, $wPob.' ');

            $mpdf->WriteText(25, 214.5, $marriage->husband_passport_no.' ');
            $mpdf->WriteText(108, 214.5, $marriage->wife_passport_no.' ');

            $dom = Carbon::parse($marriage->dom);
            $mpdf->WriteText(25, 229, $dom->format('d.m.Y').' - '.$pom);

            $qrCodeData = $this->getQrCode($marriage);
            $mpdf->Image('temp/marriage_qrcode.png', 15, 69.2, 22.2);

            $mpdf->Output();

            ob_end_flush();

        } catch (\Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    private function getQrCode(MarriageCertificate $marriage)
    {

        $result = Builder::create()
            ->writer(new PngWriter)
            ->data('https://www.bonn.mfa.af/amoas/check/verify?type=3&code='.base64_encode($marriage->serial_no))
            ->size(100)
            ->margin(0)
            ->build();

        return $result->saveToFile('temp/marriage_qrcode.png');
    }

    public function oldPrint(MarriageCertificate $marriage)
    {
        $tempName = 'templates/marriage_certificate.pdf';

        try {

            $writableData = [
                'issue_date' => $marriage->issue_date,
                'serial_no' => $marriage->serial_no,
                'pom' => $marriage->pom,
                'dom' => $marriage->dom,

                'husband_family_name' => $marriage->husband_family_name,
                'husband_given_name' => $marriage->husband_given_name,
                'husband_previous_name' => $marriage->husband_previous_name,
                'husband_dob' => $marriage->husband_dob,
                'husband_pob' => strpos($marriage->husband_pob, '/') ? $marriage->husband_pob : $marriage->husband_pob.'/AFG',
                'husband_passport_no' => $marriage->husband_passport_no,

                'wife_family_name' => $marriage->wife_family_name,
                'wife_given_name' => $marriage->wife_given_name,
                'wife_previous_name' => $marriage->wife_previous_name,
                'wife_dob' => $marriage->wife_dob,
                'wife_pob' => strpos($marriage->wife_pob, '/') ? $marriage->wife_pob : $marriage->wife_pob.'/AFG',
                'wife_passport_no' => $marriage->wife_passport_no,

            ];
            $pdf = new \FPDM($tempName);
            $pdf->Load($writableData, true); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
            // $pdf->Image(route('image.show',['employee', $photo->path]),20,100);
            $pdf->Merge();
            $pdf->Output();

        } catch (\Exception $e) {
            return abort(500, $e->getMessage());
        }
    }
}
