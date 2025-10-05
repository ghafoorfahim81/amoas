<?php

namespace App\Http\Controllers;

use App\Category;
use App\Department;
use App\Http\Requests\PackageRequest;
use App\Http\Requests\PackageUpdateRequest;
use App\Models\PostalCode;
use App\Package;
use App\Photo;
use Illuminate\Support\Facades\Session;

class AdminPackagesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:package show'])->only(['index', 'show']);
        $this->middleware(['permission:package create'])->only(['create', 'store']);
        $this->middleware(['permission:package edit'])->only(['edit', 'update']);
        $this->middleware(['permission:package delete'])->only(['destroy']);
    }
    /*
    |--------------------------------------------------------------------------
    | Admin Packages Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing booking package views to
    | admin, to show all packages, provide ability to edit and delete
    | specific package.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();

        return view('packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('packages.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageRequest $request)
    {
        $input = $request->all();

        //check if an image is selected
        if ($image = $request->file('photo_id')) {
            //give a name to image and move it to public directory
            $image_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);

            //save photo_id to package $input
            $input['photo_id'] = $photo->id;
        }

        Package::create($input);

        //set session message
        Session::flash('package_created', __('backend.package_created'));

        //redirect back to packages.index
        return redirect('/packages');
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
        $package = Package::findOrFail($id);
        $categories = Category::all();

        $departmentIds = PostalCode::select('mission_id')->distinct()->pluck('mission_id')->toArray();

        $availablePostCodeForMissions = Department::whereIn('id', $departmentIds)->pluck('name_en', 'id')->toArray();

        // remove the authencate user's department_id key from availablePostCodeForMissions
        unset($availablePostCodeForMissions[auth()->user()->department_id]);

        $isLockedForAnyMission = $package->config['is_locked_for_any_mission'] ?? null;
        $missionAreLocked = $package->config['lock_for_missions'] ?? [];

        return view('packages.edit', [
            'package' => $package,
            'categories' => $categories,
            'availablePostCodeForMissions' => $availablePostCodeForMissions,
            'isLockedForAnyMission' => $isLockedForAnyMission,
            'missionAreLocked' => $missionAreLocked,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PackageUpdateRequest $request, $id)
    {
        $input = $request->all();

        //check if image is selected
        if ($image = $request->file('photo_id')) {
            //give a name to image and move it to public directory
            $image_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);

            //save photo_id to category $input
            $input['photo_id'] = $photo->id;

            //find package
            $package = Package::findOrFail($id);

            //unlink old photo if set
            if ($package->photo != null) {
                if (file_exists(public_path() . $package->photo->file)) {
                    unlink(public_path() . $package->photo->file);
                }
            }

            //delete data from photos table
            Photo::destroy($package->photo_id);
        }
        //update data into packages table
        $package = Package::findOrFail($id);

        // edit $package->config which is an json field
        $config = $package->config;

        // remove null from input->lock_for_missions
        $lockForMissions = array_filter($input['lock_for_missions']);

        if (! empty($lockForMissions)) {
            // add is_locked_for_any_mission to config
            $config['is_locked_for_any_mission'] = true;

            // add lock_for_missions to config
            $config['lock_for_missions'] = $lockForMissions;
        } else {
            // remove is_locked_for_any_mission from config
            unset($config['is_locked_for_any_mission']);

            // remove lock_for_missions from config
            unset($config['lock_for_missions']);
        }

        $input['config'] = $config;

        $package->update($input);
        //set session message and redirect back packages.index
        Session::flash('package_updated', __('backend.package_updated'));

        return redirect('/packages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find specific package
        $package = Package::findOrFail($id);

        if ($package->photo) {

            // check if photo exists and unlink it
            if (file_exists(public_path() . $package->photo->file)) {
                unlink(public_path() . $package->photo->file);
            }

            //delete from photo table
            Photo::destroy($package->photo_id);
        }

        //delete package
        Package::destroy($package->id);

        //set session message and redirect back to packages.index
        Session::flash('package_deleted', __('backend.package_deleted'));

        return redirect('/packages');
    }

    /**
     * Print the package details in PDF format.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf(Package $package)
    {
        $defaultConfig = (new \Mpdf\Config\ConfigVariables)->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables)->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [
                public_path('fonts'),
            ]),
            'fontdata' => $fontData + [
                'IranSans' => [
                    'R' => 'IranSansRegular.ttf',
                    'B' => 'IranSansBold.ttf',
                ],
            ],
            'default_font' => 'IranSans',
            'mode' => 'utf-8',
            'format' => 'A4',
            'charset_in' => 'UTF-8',
            'allow_charset_conversion' => true,
            'curlFollowLocation' => true,
            'curlAllowUnsafeSslRequests' => false,
        ]);

        $mpdf->WriteHTML($package->description);

        return $mpdf->Output();
    }
}
