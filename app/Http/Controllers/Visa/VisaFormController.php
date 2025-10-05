<?php

namespace App\Http\Controllers\Visa;

use App\Http\Controllers\Controller;
use App\Models\Visa\VisaForm;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class VisaFormController extends Controller
{
    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $visaForms = VisaForm::with(['department', 'country', 'type', 'registrar'])
            ->latest()
            ->paginate($limit);

        // dd($visaForms);
        return view('visa.index', compact('visaForms'));
    }

    public function show(VisaForm $visa_form)
    {
        $visa_form->load(['department', 'country', 'type', 'image', 'registrar']);

        $off_days = \DB::table('booking_times')
            ->where('is_off_day', '=', '1')
            ->get();

        $dayNumber = [];

        foreach ($off_days as $off_day) {
            if ($off_day->id != 7) {
                $dayNumber[] = $off_day->id;
            } else {
                $dayNumber[] = $off_day->id - 7;
            }
        }

        $disable_days_string = implode(',', $dayNumber);

        $packageId = \App\Models\Visa\VisaForm::getPackageId();

        return view('visa.show', compact('visa_form', 'disable_days_string', 'packageId'));
    }

    public function fillForm()
    {
        if (request()->has('mission')) {
            $department = \App\Department::where('code', strtoupper(request()->mission))->where('status', 1)->first();
            if ($department) {
                request()->session()->put('department', $department);
            }
        }

        return view('visa.form.fill-form');
    }

    public function store()
    {

        $this->validate(request(), [
            'department_id' => 'required',
            'title' => 'required',
            'family_name' => 'required',
            'given_name' => 'required',
            'father_name' => 'required',
            'dob' => 'required',
            'birth_country' => 'required',
            'marital_status' => 'required',
            'gender' => 'required',
            'residence_country' => 'required',
            'nationality' => 'required',
            'under_18' => 'required',
            'address' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'occupation' => 'required',
            'visa_type' => 'required',
            'purpose' => 'required',
            'entry_date' => 'required',
            'intend_duration' => 'required',
            'entry_point' => 'required',
            // 'children_no' => 'required',
            'visit_places' => 'required',
            'af_address' => 'required',
            'passport_type' => 'required',
            'passport_no' => 'required',
            'issue_place' => 'required',
            'issue_date' => 'required',
            'expire_date' => 'required',
            'photo' => 'required',
        ]);

        $visaForm = VisaForm::create([
            'department_id' => request()->department_id,
            'serial_no' => VisaForm::generateSerialNo(request()->department_id),
            'title' => request()->title,
            'family_name' => request()->family_name,
            'given_name' => request()->given_name,
            'father_name' => request()->father_name,
            'dob' => request()->dob,
            'birth_country' => request()->birth_country,
            'marital_status' => request()->marital_status,
            'gender' => request()->gender,
            'residence_country' => request()->residence_country,
            'nationality' => request()->nationality,
            'other_nationality' => request()->other_nationality,
            'under_18' => request()->under_18,
            'address' => request()->address,
            'email' => request()->email,
            'mobile' => request()->mobile,
            'occupation' => request()->occupation,
            'employer_name' => request()->employer_name,
            'employer_address' => request()->employer_address,
            'pre_employer_name' => request()->pre_employer_name,
            'status' => 'On Process',
            'pre_employer_address' => request()->pre_employer_address,
            'visa_type' => request()->visa_type,
            'purpose' => request()->purpose,
            'entry_date' => request()->entry_date,
            'intend_duration' => request()->intend_duration,
            'entry_point' => request()->entry_point,
            'children_no' => request()->children_no,
            'visit_places' => request()->visit_places,
            'af_address' => request()->af_address,
            'visited_before' => request()->visited_before,
            'applied_visa' => request()->applied_visa,
            'criminal_record' => request()->criminal_record,
            'passport_type' => request()->passport_type,
            'passport_no' => request()->passport_no,
            'issue_place' => request()->issue_place,
            'issue_date' => request()->issue_date,
            'expire_date' => request()->expire_date,
            'registrar_id' => auth()->check() ? auth()->id() : 0,
        ]);

        if (request()->hasFile('photo')) {

            $extension = request()->photo->getClientOriginalExtension();

            $fullPath = \Storage::disk('visa')->putFile($visaForm->serial_no, new File(request()->photo));

            $visaForm->image()->create([
                'label' => request()->photo->getClientOriginalName(),
                'path' => $fullPath,
                'mime_type' => $extension,
            ]);
        }

        $visaForm->load(['department']);
        \App\Jobs\FinalizeVisaFormRegistration::dispatch($visaForm);

        return redirect(route('visa.complete', [$visaForm->id]));
    }

    public function checkStatus()
    {
        $visa = null;
        $message = null;

        return view('visa.form.check-visa', compact('visa', 'message'));
    }

    public function visaComplete(VisaForm $visa_form)
    {
        $visa_form->load(['department:id,name_en']);

        return view('visa.form.visa-completion', compact('visa_form'));
    }

    public function print(VisaForm $visa_form)
    {
        $visa_form->load(['department', 'country', 'type', 'image', 'birthCountry']);

        $pdf = new \FPDM('templates/visa_fixed.pdf');
        $pdf->Load([
            'serial_no' => $visa_form->serial_no,
            'Title' => ucfirst($visa_form->title),
            'Family_Name' => $visa_form->family_name,
            'Given_Names' => $visa_form->given_name,
            'Father_Name' => $visa_form->father_name,
            'DoB' => date('m/d/y', strtotime($visa_form->dob)),
            'Country_of_birth' => $visa_form->birthCountry->name_en,
            'marital_status' => ucfirst($visa_form->marital_status),
            'Country_of_Residence' => $visa_form->country->name_en,
            'Nationality' => $visa_form->nationality,
            'Other_Nationalities' => $visa_form->other_nationality,
            'Current_Address' => $visa_form->address,
            'Email' => $visa_form->email,
            'Mobile' => $visa_form->mobile,
            'Current_Occupation' => $visa_form->occupation,
            'Employers_Name' => $visa_form->employer_name,
            'Employeers_Address' => $visa_form->employer_address,
            'Previous_Employeers_Name' => $visa_form->pre_employer_name,
            'Previous_Employeers_Address' => $visa_form->pre_employer_address,
            'Visa_Type' => $visa_form->type->label_en,
            'purpose' => $visa_form->purpose,
            'Entry_Date' => date('m/d/y', strtotime($visa_form->entry_date)),
            'Intended Duration of Stay' => $visa_form->intend_duration,
            'Point of Entry' => $visa_form->entry_point,
            'Number_of_Children' => $visa_form->children_no,
            'Places in Afghanistan intended to visit' => $visa_form->visit_places,
            'Complete Address in Afghanistan' => $visa_form->af_address,
            'Place_visit_afghanistan' => $visa_form->visited_before,
            'Visa_Applied_Before' => $visa_form->visited_before,
            'Crime_Details' => $visa_form->criminal_record,
            'Passport_Type' => $visa_form->passport_type,
            'Passport_Number' => $visa_form->passport_no,
            'Place_of_Issue' => $visa_form->issue_place,
            'Issue_date_af_date' => date('m/d/y', strtotime($visa_form->issue_date)),
            'Expiry_date_af_date' => date('m/d/y', strtotime($visa_form->expire_date)),
            // 'Male'=> $visa_form->gender == 'male' ? 'On' : 'No',
            // 'Female'=> $visa_form->gender == 'female' ? 'Yes' : 'No',
            'gender' => ucfirst($visa_form->gender),
            'under_18' => $visa_form->gender == '1' ? 'Yes' : 'No',
        ], true); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
        // $pdf->Image('logo.png');
        $pdf->Merge();
        $pdf->Output();
        // $pdf->Output('', 'temp/visa_fixed.pdf');
    }

    public function doCheckStatus()
    {
        $visa = VisaForm::withoutGlobalScope(\App\Scopes\DepartmentScope::class)->with('department:id,name_en')->where('serial_no', request()->serial_no)->first();

        $message = $visa ? null : 'The serial number you are looking for was not found.';

        return view('visa.form.check-visa', compact('visa', 'message'));
    }

    public function approve(VisaForm $visa_form)
    {
        // return request()->all();
        $this->validate(request(), [
            'event_date' => 'date|required',
            'booking_slot' => 'required',
        ]);
        \DB::beginTransaction();
        $booking = \App\Booking::create([
            'user_id' => $visa_form->registrar_id,
            'package_id' => request('package_id'),
            'department_id' => $visa_form->department_id,
            'serial_no' => \App\Booking::genSerialNo($visa_form->department_id),
            'booking_date' => request()->event_date,
            'booking_time' => request()->booking_slot,
            'email' => $visa_form->email,
            'booking_type' => request()->booking_type ?? 'Ordinary',
            'status' => 'Processing',
        ]);

        $booking->info()->create([
            'full_name' => $visa_form->given_name.' '.$visa_form->family_name,
            'email' => $visa_form->email,
            'phone' => $visa_form->mobile,
            'id_card' => $visa_form->passport_no,
            'postal' => 'N/A',
            'address' => 'N/A',
        ]);

        $visa_form->status = __('backend.approvedInterviewOn').$booking->booking_date.' '.$booking->booking_time;
        $visa_form->save();
        \DB::commit();

        $booking->load(['user', 'info', 'package', 'department']);
        \App\Jobs\FinalizeNewBooking::dispatch($booking);
        \App\Jobs\VisaApplicationApproved::dispatch($visa_form);

        return back()->with([
            'alert' => __('backend.action.performed'),
        ]);
    }

    public function reject(VisaForm $visa_form)
    {
        $visa_form->status = __('backend.rejectByReason');
        $visa_form->save();

        \App\Jobs\VisaApplicationRejected::dispatch($visa_form);

        return back()->with([
            'alert' => __('backend.action.performed'),
            'class' => 'alert-danger',
        ]);
    }

    public function dataTable()
    {
        $visaForms = VisaForm::with(['department', 'country', 'type', 'registrar'])->latest();

        return Datatables::of($visaForms)
            ->addColumn('name', function ($visaForm) {
                $name = ucwords($visaForm->title.' '.$visaForm->given_name.' '.$visaForm->family_name);

                return $name;
            })
            ->addColumn('action', function ($visaForms) {
                $action = '<a href="'.route('visa-form.show', $visaForms->id).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>&nbsp;';

                return $action;
            })
            ->make(true);
    }
}
