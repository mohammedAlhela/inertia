<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Exports\Main\CourseExport;
use App\Http\Requests\Main\CourseRequest;
use App\Models\Course;
use Excel;
use Helper;
use Illuminate\Http\Request;
use PdfReport;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $records = Course::with(['department' , 'subjects'])->get();

        foreach ($records as $record) {

            $record->select = false;
        }


        return inertia('App/Main/Courses/Index', [
            'Courses' => $records
        ]);

    }

    public function create()
    {
        return inertia('App/Main/Courses/Create');
    }

    public function store(CourseRequest $request)
    {

        Course::create($request->except('created_at', 'updated_at'));

    }

    public function edit($id)
    {

        return inertia('App/Main/Courses/Edit', [
            'Course' => Course::find($id),
        ]);

    }

    public function update(CourseRequest $request, $id)
    {

        Course::where('id', $id)->update($request->except('created_at', 'updated_at'));
    }

    public function delete($ids)
    {

        $ids = Helper::getArrayFromString($ids);

        $Courses = Course::whereIn('id', $ids)->delete();

    }

    public function exportPdf(Request $request, $ids)
    {
        $ids = Helper::getArrayFromString($ids);

        $Courses = Course::with(['department' , 'subjects'])->whereIn('id', $ids)->get();

        $data = array(
            'Courses' => $Courses,
            'company' => Helper::getCompany(),
        );

        $pdf = PdfReport::loadView('main.courses.pdf', array('data' => $data));
        return $pdf->download('courses.pdf');

    }

    public function exportExcel($ids)
    {
        $ids = Helper::getArrayFromString($ids);

        return Excel::download(new CourseExport($ids), 'courses.xlsx');
    }

}
