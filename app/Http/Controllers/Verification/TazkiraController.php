<?php

namespace App\Http\Controllers\Verification;

use App\Http\Controllers\Controller;
use App\Models\Verification\Verification;
use Illuminate\Http\File;
use Illuminate\Http\Request;

class TazkiraController extends Controller
{
    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $verifications = null;
        if (auth()->user()->isAdmin()) {
            $verifications = Verification::with(['country', 'sibling', 'service'])
                ->latest()
                ->paginate($limit);
        } else {
            $verifications = Verification::with(['country', 'sibling', 'service'])
                ->where('registrar_id', auth()->id())
                ->latest()
                ->paginate($limit);
        }

        // dd($verifications);
        return view('tazkira.verification.index', compact('verifications'));
    }

    public function show(Verification $verification)
    {
        $verification->load(['country', 'sibling', 'service', 'province', 'district', 'village', 'image']);

        return view('tazkira.verification.show', compact('verification'));
    }

    public function fillForm()
    {
        return view('verification.tazkira.fill-form');
    }

    public function create()
    {
        return redirect(route('verfiy.tazkira'));
    }

    public function store()
    {
        // dd(request()->all());
        $this->validate(request(), [
            'name' => 'required',
            'last_name' => 'required',
            'father_name' => 'required',
            'grand_father_name' => 'required',
            'occupation' => 'required',
            'birth_place' => 'required',
            'marital_status' => 'required',
            'living_duration' => 'required',
            'living_duration_unit' => 'required',
            'last_trip' => 'required',
            'contact_no' => 'required',
            'email' => 'required',
            'photo' => 'required',
            'service_id' => 'required',
            'original_village' => 'required',
            'original_district' => 'required',
            'original_province' => 'required',
            'current_city' => 'required',
            'zip_code' => 'required',
            'current_country' => 'required',
            'height' => 'required',
            'eyes' => 'required',
            'skin' => 'required',
            'hair' => 'required',
            'd_name' => 'required',
            'd_last_name' => 'required',
            'd_contact' => 'required',
            'sibling_name' => 'required',
            'sibling_last_name' => 'required',
            'sibling_id' => 'required',
            'page_no' => 'required',
            'version_no' => 'required',
            'note_no' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
        ]);

        $tazkiraVerify = Verification::create([
            'department_id' => 1,
            'name' => request()->name,
            'last_name' => request()->last_name,
            'father_name' => request()->father_name,
            'grand_father_name' => request()->grand_father_name,
            'occupation' => request()->occupation,
            'birth_place' => request()->birth_place,
            'marital_status' => request()->marital_status,
            'living_duration' => request()->living_duration,
            'living_duration_unit' => request()->living_duration_unit,
            'last_trip' => request()->last_trip,
            'contact_no' => request()->contact_no,
            'email' => request()->email,
            'service_id' => request()->service_id,
            'new_absence_tazkira_case' => request()->new_absence_tazkira_case,
            'original_village' => $this->setAttr(request()->original_village, 'App\Village'),
            'original_province' => request()->original_province,
            'original_district' => $this->setAttr(request()->original_district, 'App\District'),
            'current_city' => request()->current_city,
            'zip_code' => request()->zip_code,
            'current_country' => request()->current_country,
            'height' => request()->height,
            'eyes' => request()->eyes,
            'skin' => request()->skin,
            'hair' => request()->hair,
            'other' => request()->other,
            'd_name' => request()->d_name,
            'd_last_name' => request()->d_last_name,
            'd_father_name' => request()->d_father_name,
            'd_contact' => request()->d_contact,
            'sibling_name' => request()->sibling_name,
            'sibling_last_name' => request()->sibling_last_name,
            'sibling_father_name' => request()->sibling_father_name,
            'sibling_grand_father_name' => request()->sibling_grand_father_name,
            'sibling_id' => request()->sibling_id,
            'page_no' => request()->page_no,
            'version_no' => request()->version_no,
            'note_no' => request()->note_no,
            'year' => request()->year,
            'month' => request()->month,
            'day' => request()->day,
            'registrar_id' => auth()->id(),
        ]);

        if (request()->hasFile('photo')) {

            $extension = request()->photo->getClientOriginalExtension();

            $name = str_replace(' ', '_', $tazkiraVerify->name).'-'.str_replace(' ', '_', $tazkiraVerify->last_name).'-'.str_replace(' ', '_', $tazkiraVerify->father_name).'-'.time();

            $fullPath = \Storage::disk('verification')->putFile($name, new File(request()->photo));

            $tazkiraVerify->image()->create([
                'label' => request()->photo->getClientOriginalName(),
                'path' => $fullPath,
                'mime_type' => $extension,
            ]);
        }

        return redirect(route('verification.index'));
    }

    public function edit(Verification $verification)
    {
        $verification->load(['country', 'sibling', 'service', 'province', 'district', 'village', 'image']);

        return view('tazkira.verification.edit', compact('verification'));
    }

    public function update(Verification $verification)
    {
        // dd(request()->all());
        $this->validate(request(), [
            'name' => 'required',
            'last_name' => 'required',
            'father_name' => 'required',
            'grand_father_name' => 'required',
            'occupation' => 'required',
            'birth_place' => 'required',
            'marital_status' => 'required',
            'living_duration' => 'required',
            'living_duration_unit' => 'required',
            'last_trip' => 'required',
            'contact_no' => 'required',
            'email' => 'required',
            'service_id' => 'required',
            'original_village' => 'required',
            'original_district' => 'required',
            'original_province' => 'required',
            'current_city' => 'required',
            'zip_code' => 'required',
            'current_country' => 'required',
            'height' => 'required',
            'eyes' => 'required',
            'skin' => 'required',
            'hair' => 'required',
            'd_name' => 'required',
            'd_last_name' => 'required',
            'd_contact' => 'required',
            'sibling_name' => 'required',
            'sibling_last_name' => 'required',
            'sibling_id' => 'required',
            'page_no' => 'required',
            'version_no' => 'required',
            'note_no' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
        ]);

        $verification->update([
            'name' => request()->name,
            'last_name' => request()->last_name,
            'father_name' => request()->father_name,
            'grand_father_name' => request()->grand_father_name,
            'occupation' => request()->occupation,
            'birth_place' => request()->birth_place,
            'marital_status' => request()->marital_status,
            'living_duration' => request()->living_duration,
            'living_duration_unit' => request()->living_duration_unit,
            'last_trip' => request()->last_trip,
            'contact_no' => request()->contact_no,
            'email' => request()->email,
            'service_id' => request()->service_id,
            'new_absence_tazkira_case' => request()->new_absence_tazkira_case,
            'original_village' => $this->setAttr(request()->original_village, 'App\Village'),
            'original_province' => request()->original_province,
            'original_district' => $this->setAttr(request()->original_district, 'App\District'),
            'current_city' => request()->current_city,
            'zip_code' => request()->zip_code,
            'current_country' => request()->current_country,
            'height' => request()->height,
            'eyes' => request()->eyes,
            'skin' => request()->skin,
            'hair' => request()->hair,
            'other' => request()->other,
            'd_name' => request()->d_name,
            'd_last_name' => request()->d_last_name,
            'd_father_name' => request()->d_father_name,
            'd_contact' => request()->d_contact,
            'sibling_name' => request()->sibling_name,
            'sibling_last_name' => request()->sibling_last_name,
            'sibling_father_name' => request()->sibling_father_name,
            'sibling_grand_father_name' => request()->sibling_grand_father_name,
            'sibling_id' => request()->sibling_id,
            'page_no' => request()->page_no,
            'version_no' => request()->version_no,
            'note_no' => request()->note_no,
            'year' => request()->year,
            'month' => request()->month,
            'day' => request()->day,
        ]);

        if (request()->hasFile('photo')) {

            $extension = request()->photo->getClientOriginalExtension();

            $name = str_replace(' ', '_', $verification->name).'-'.str_replace(' ', '_', $verification->last_name).'-'.str_replace(' ', '_', $verification->father_name).'-'.time();

            $fullPath = \Storage::disk('verification')->putFile($name, new File(request()->photo));

            \Storage::disk('verification')->delete($verification->image->path);

            $verification->image()->update([
                'label' => request()->photo->getClientOriginalName(),
                'path' => $fullPath,
                'mime_type' => $extension,
            ]);
        }

        return redirect(route('verification.index'));
    }

    private function setAttr($attr, $model)
    {
        if (is_numeric($attr)) {
            return $attr;
        }

        $instance = new $model;
        $instance->name = $attr;
        $instance->label_en = $attr;
        $instance->label_dr = $attr;
        $instance->save();

        return $instance->id;
    }

    public function printExcel(Verification $verification)
    {

        $spreadsheet = $this->excelWriter($verification);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('temp/verification_form.xlsx');

        return response()->download('temp/verification_form.xlsx');
    }

    public function printPdf(Verification $verification)
    {
        ini_set('memory_limit', '-1');
        $spreadsheet = $this->excelWriter($verification);

        $xmlWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
        $xmlWriter->save('temp/verification_form.pdf', 'landscape');

        return response()->download('temp/verification_form.pdf');
    }

    private function excelWriter(Verification $verification)
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('templates/verification_form_template.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        // dd($spreadsheet);
        $sheet->setCellValue('D5', $verification->name.' '.$verification->last_name);
        $sheet->setCellValue('D6', $verification->father_name);
        $sheet->setCellValue('D7', $verification->grand_father_name);
        $sheet->setCellValue('D8', $verification->birth_place);
        $sheet->setCellValue('D9', __('tazkira.'.$verification->marital_status));
        $sheet->setCellValue('D10', $verification->occupation);
        $sheet->setCellValue('D11', $verification->living_duration.' '.__('tazkira.'.$verification->living_duration_unit));

        $sheet->setCellValue('D12', $verification->last_trip);
        $sheet->setCellValue('D13', $verification->contact_no);
        $sheet->setCellValue('D14', $verification->email);
        $sheet->setCellValue('D15', app()->isLocale('dr') || app()->isLocale('ps') ? $verification->service->label_dr : $verification->service->label_en);
        $sheet->setCellValue('D16', $verification->new_absence_tazkira_case);

        // Addresses
        $sheet->setCellValue('I5', app()->isLocale('dr') || app()->isLocale('ps') ? $verification->village->label_dr : $verification->village->label_en);
        $sheet->setCellValue('J5', app()->isLocale('dr') || app()->isLocale('ps') ? $verification->district->label_dr : $verification->district->label_en);
        $sheet->setCellValue('K5', app()->isLocale('dr') || app()->isLocale('ps') ? $verification->province->label_dr : $verification->province->label_en);
        $sheet->setCellValue('I6', $verification->current_city);
        $sheet->setCellValue('J6', $verification->zip_code);
        $sheet->setCellValue('K6', app()->isLocale('dr') || app()->isLocale('ps') ? $verification->country->name_dr : $verification->country->name_en);
        $sheet->setCellValue('I9', $verification->height);
        $sheet->setCellValue('I10', $verification->eyes);
        $sheet->setCellValue('I11', $verification->skin);
        $sheet->setCellValue('I12', $verification->hair);
        $sheet->setCellValue('I13', $verification->other);
        $sheet->setCellValue('J14', $verification->d_name.' '.$verification->d_last_name);
        $sheet->setCellValue('K14', $verification->d_contact);

        $sheet->setCellValue('D18', $verification->sibling_name.' '.$verification->sibling_last_name);
        // $sheet->setCellValue('D5', );

        $sheet->setCellValue('I18', $verification->sibling_father_name);
        $sheet->setCellValue('D19', $verification->sibling_grand_father_name);
        $sheet->setCellValue('I19', app()->isLocale('dr') || app()->isLocale('ps') ? $verification->sibling->label_dr : $verification->sibling->label_en);
        $sheet->setCellValue('D20', $verification->page_no);
        $sheet->setCellValue('E20', $verification->version_no);
        $sheet->setCellValue('F20', $verification->note_no);
        $sheet->setCellValue('I20', $verification->year);
        $sheet->setCellValue('J20', $verification->month);
        $sheet->setCellValue('K20', $verification->day);

        // insert image
        // $sheeti = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        // $sheeti->setName('name');
        // $sheeti->setDescription('description');
        // $sheeti->setPath('img.png');
        // $sheeti->setHeight(90);
        // $sheeti->setCoordinates("J9");
        // $sheeti->setOffsetX(20);
        // $sheeti->setOffsetY(5);
        // $sheeti->setWorksheet($sheet);

        return $spreadsheet;

    }

    public function printWord(Verification $verification)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord;

        $template = $phpWord->loadTemplate('templates/verification_form_template.docx');
        // dd($spreadsheet);
        $template->setValue('name', $verification->name.' '.$verification->last_name);
        $template->setValue('father_name', $verification->father_name);
        $template->setValue('grand_father_name', $verification->grand_father_name);
        $template->setValue('birth_place', $verification->birth_place);
        $template->setValue('marital_status', __('tazkira.'.$verification->marital_status));
        $template->setValue('occupation', $verification->occupation);
        $template->setValue('living_duration', $verification->living_duration.' '.__('tazkira.'.$verification->living_duration_unit));

        $template->setValue('last_trip', $verification->last_trip);
        $template->setValue('contact_no', $verification->contact_no);
        $template->setValue('email', $verification->email);
        $template->setValue('service_id', app()->isLocale('dr') || app()->isLocale('ps') ? $verification->service->label_dr : $verification->service->label_en);
        $template->setValue('new_absence_tazkira_case', $verification->new_absence_tazkira_case);

        // Addresses
        $template->setValue('original_village', app()->isLocale('dr') || app()->isLocale('ps') ? $verification->village->label_dr : $verification->village->label_en);
        $template->setValue('original_district', app()->isLocale('dr') || app()->isLocale('ps') ? $verification->district->label_dr : $verification->district->label_en);
        $template->setValue('original_province', app()->isLocale('dr') || app()->isLocale('ps') ? $verification->province->label_dr : $verification->province->label_en);
        $template->setValue('current_city', $verification->current_city);
        $template->setValue('zip_code', $verification->zip_code);
        $template->setValue('current_country', app()->isLocale('dr') || app()->isLocale('ps') ? $verification->country->name_dr : $verification->country->name_en);
        $template->setValue('height', $verification->height);
        $template->setValue('eyes', $verification->eyes);
        $template->setValue('skin', $verification->skin);
        $template->setValue('hair', $verification->hair);
        $template->setValue('other', $verification->other);
        $template->setValue('d_name', $verification->d_name.' '.$verification->d_last_name);
        $template->setValue('d_contact', $verification->d_contact);

        $template->setValue('sibling_name', $verification->sibling_name.' '.$verification->sibling_last_name);
        // $template->setValue('D5', );

        $template->setValue('sibling_father_name', $verification->sibling_father_name);
        $template->setValue('sibling_grand_father_name', $verification->sibling_grand_father_name);
        $template->setValue('sibling_id', app()->isLocale('dr') || app()->isLocale('ps') ? $verification->sibling->label_dr : $verification->sibling->label_en);
        $template->setValue('page_no', $verification->page_no);
        $template->setValue('version_no', $verification->version_no);
        $template->setValue('note_no', $verification->note_no);
        $template->setValue('year', $verification->year);
        $template->setValue('month', $verification->month);
        $template->setValue('day', $verification->day);

        $template->saveAs('temp/verification_form.docx');

        return response()->download('temp/verification_form.docx');
    }
}
