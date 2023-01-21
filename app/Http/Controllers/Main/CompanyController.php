<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\Main\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Image;
use PDF;

class CompanyController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return inertia('App/Main/Company', [
            'company' => Company::find(1),
        ]);
    }

    public function update(CompanyRequest $request, $id)
    {

        $image = request()->file("image");

        $company = Company::where('id', 1)->update($request->except('image', 'created_at', 'updated_at'));

        $company = Company::find(1);

        if ($image) {

            if (file_exists(public_path() . $company->image)) {
                unlink(substr($company->image, 1));
            }

            Image::make($image)->fit(100, 100)->save(public_path("/images/main/company.webp"));
            $company->image = "/images/main/company.webp";
        }

        $company->save();

    }
    public function exportPdf()
    {
        $company = Company::find(1);
        $data = [
            'name' => $company->name,
            'email' => $company->email,
            'address' => $company->address,
            'image' => $company->image,
            'mobile' => $company->mobile,
            'company_register' => $company->company_register,

        ];
        $pdf = PDF::loadView('company', array('data' => $data));

        return $pdf->download('company.pdf');

    }

}