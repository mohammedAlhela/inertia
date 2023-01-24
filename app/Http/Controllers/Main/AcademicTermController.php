<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Exports\Main\AcademicTermExport;
use App\Http\Requests\Main\AcademicTermRequest;
use App\Models\AcademicTerm;
use Excel;
use Helper;
use Illuminate\Http\Request;
use PdfReport;

class AcademicTermController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        return inertia('App/Main/AcademicTerms/Index', [
            'academicTerms' => AcademicTerm::all(),
        ]);

    }

    public function create()
    {
        return inertia('App/Main/Academicterms/Create');
    }

    public function store(AcademicTermRequest $request)
    {

        AcademicTerm::create($request->except('created_at', 'updated_at'));

    }

    public function edit($id)
    {

        return inertia('App/Main/AcademicTerms/Edit', [
            'academicTerm' => AcademicTerm::find($id),
        ]);

    }

    public function update(AcademicTermRequest $request, $id)
    {

        AcademicTerm::update($request->except('created_at', 'updated_at'))->where('id', $id);
    }

    public function delete($ids)
    {

        $ids = Helper::getArrayFromString($ids);

        $academicTerms = AcademicTerm::whereIn('id', $ids)->get();

        foreach ($academicTerms as $academicTerm) {
            $academicTerm->delete();
        }

    }

    public function exportPdf(Request $request, $ids)
    {
        $ids = Helper::getArrayFromString($ids);

        $academicTerms = AcademicTerm::with('academicYear')->whereIn('id', $ids)->get();

        $data = array(
            'academicTerms' => $academicTerms,
            'company' => Helper::getCompany(),
        );

        $pdf = PdfReport::loadView('main.academicTerms.pdf', array('data' => $data));
        return $pdf->download('academicTerms.pdf');

    }

    public function exportExcel($ids)
    {
        $ids = Helper::getArrayFromString($ids);

        return Excel::download(new AcademicTermExport($ids), 'academicTerms.xlsx');
    }

}
