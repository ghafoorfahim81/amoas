<?php

namespace App\Http\Controllers\Tasaadiq;

use App\Http\Controllers\Controller;
use App\Models\Tasaadiq\BirthCertificate;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class BirthCertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:birth certificate show'])->only(['index', 'show']);
        $this->middleware(['permission:birth certificate create'])->only(['create', 'store']);
        $this->middleware(['permission:birth certificate edit'])->only(['edit', 'update']);
        $this->middleware(['permission:birth certificate delete'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tasaadiq.birth.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasaadiq.birth.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'family_name' => 'required',
            'given_name' => 'required',
            'sex' => 'required',
            'dob' => 'required',
            'pob' => 'required_without:pob_outside',
            'pob_outside' => 'required_without:pob',
            'father_name' => 'required',
            'mother_name' => 'required',
        ]);

        \DB::beginTransaction();
        try {
            $serialNo = BirthCertificate::generateSerialNo();

            $newBC = BirthCertificate::create([
                'family_name' => strtoupper($request->family_name),
                'given_name' => strtoupper($request->given_name),
                'previous_name' => strtoupper($request->previous_name),
                'sex' => strtoupper($request->sex),
                'dob' => $request->dob,
                'pob' => $request->filled('pob_outside') ? strtoupper($request->pob_outside) : strtoupper($request->pob),
                'passport_no' => strtoupper($request->passport_no),
                'father_name' => strtoupper($request->father_name),
                'mother_name' => strtoupper($request->mother_name),
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

        return redirect()->route('birth.show', [$newBC])->with(['print' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BirthCertificate $birth)
    {
        return view('tasaadiq.birth.show', compact('birth'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BirthCertificate $birth)
    {
        return view('tasaadiq.birth.edit', compact('birth'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BirthCertificate $birth)
    {
        $this->validate($request, [
            'family_name' => 'required',
            'given_name' => 'required',
            'sex' => 'required',
            'dob' => 'required',
            'pob' => 'required_without:pob_outside',
            'pob_outside' => 'required_without:pob',
            'passport_no' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
        ]);

        \DB::beginTransaction();
        try {
            $birth->update([
                'family_name' => strtoupper($request->family_name),
                'given_name' => strtoupper($request->given_name),
                'previous_name' => strtoupper($request->previous_name),
                'sex' => strtoupper($request->sex),
                'dob' => $request->dob,
                'pob' => $request->filled('pob_outside') ? strtoupper($request->pob_outside) : strtoupper($request->pob),
                'passport_no' => strtoupper($request->passport_no),
                'father_name' => strtoupper($request->father_name),
                'mother_name' => strtoupper($request->mother_name),
            ]);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }

        return redirect()->route('birth.show', [$birth]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BirthCertificate $birth)
    {
        $birth->delete();

        return redirect()->route('birth.index');
    }

    public function dataTable()
    {
        $births = BirthCertificate::with(['registrar:id,last_name'])->select('birth_certificates.*');

        if (! request()->order) {
            $births->latest();
        }

        return datatables()::of($births)
            ->addColumn('action', function ($birth) {
                $action = '<a href="'.route('birth.show', $birth->id).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>&nbsp;';

                // $action .= '<a href="' . route('bookings.edit', $booking->id) .'" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>';
                return $action;
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function print(BirthCertificate $birth)
    {
        if ($birth->print_type == 'new') {
            return $this->newPrint($birth);
        }

        return $this->oldPrint($birth);
    }

    public function newPrint(BirthCertificate $birth)
    {
        $tempName = 'templates/birth_certificate_new_update.pdf';

        try {

            $pob = strpos($birth->pob, '/') ? $birth->pob : $birth->pob.'/AFG';

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
            $mpdf->WriteText(42, 68.5, $birth->serial_no.' ');

            $issueDate = Carbon::parse($birth->issue_date);

            $mpdf->WriteText(42, 82, $issueDate->format('d.m.Y').' ');

            $mpdf->SetFont('biosans', 'R', 13);
            $mpdf->WriteText(25, 116, $birth->family_name.' ');

            $mpdf->WriteText(25, 131, $birth->given_name.' ');

            $mpdf->WriteText(25, 145, $birth->previous_name.' ');

            $mpdf->WriteText(25, 160, $birth->sex.' ');

            $dob = Carbon::parse($birth->dob);
            $mpdf->WriteText(25, 174.5, $dob->format('d.m.Y').' ');

            $pob = strpos($birth->pob, '/') ? $birth->pob : $birth->pob.'/AFG';
            $mpdf->WriteText(25, 189, $pob.' ');

            $mpdf->WriteText(25, 203.5, $birth->father_name.' ');

            $mpdf->WriteText(25, 218, $birth->mother_name.' ');

            $mpdf->WriteText(25, 233, $birth->passport_no.' ');

            $qrCodeData = $this->getQrCode($birth);
            $mpdf->Image('temp/birth_qrcode.png', 15, 61.5, 22.2);

            $mpdf->Output();

            ob_end_flush();

        } catch (\Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    private function getQrCode(BirthCertificate $birth)
    {

        $result = Builder::create()
            ->writer(new PngWriter)
            ->data('https://www.bonn.mfa.af/amoas/check/verify?type=1&code='.base64_encode($birth->serial_no))
            ->size(100)
            ->margin(0)
            ->build();

        return $result->saveToFile('temp/birth_qrcode.png');
    }

    public function oldPrint(BirthCertificate $birth)
    {
        $tempName = 'templates/birth_certificate.pdf';

        try {

            $pob = strpos($birth->pob, '/') ? $birth->pob : $birth->pob.'/AFG';
            $writableData = [
                'family_name' => $birth->family_name,
                'given_name' => $birth->given_name,
                'previous_name' => $birth->previous_name,
                'sex' => $birth->sex,
                'dob' => $birth->dob,
                'pob' => $pob,
                'passport_no' => $birth->passport_no,
                'issue_date' => $birth->issue_date,
                'serial_no' => $birth->serial_no,
                'mother_name' => $birth->mother_name,
                'father_name' => $birth->father_name,
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
