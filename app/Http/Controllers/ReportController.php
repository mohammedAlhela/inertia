<?php

namespace App\Http\Controllers;

// use App\Models\Employee;
// use Carbon\Carbon;
// use Excel;
// use Helper;
// use Illuminate\Http\Request;
// use PdfReport;
// use App\Exports\EmployeeSalaryExpenseDeductionExport;

class ReportController extends Controller
{

    // protected $totalBouns;

    // protected $totalExpenses;

    public function __construct()
    {

        $this->middleware('auth');

        // $this->middleware('activeUser');

    }

    public function index()
    {

        // $authArray = array('report', 'show');

        // Helper::authorizeModel($authArray);

        return inertia('Reports');

    }


    
    public function showCharts()
    {

        // $authArray = array('report', 'show');

        // Helper::authorizeModel($authArray);

        return inertia('Charts');

    }


    

    // public function getData()
    // {

    //     $authArray = array('report', 'show');

    //     Helper::authorizeModel($authArray);

    //     $employees = Employee::all();

    //     $genders = Employee::distinct('gender')->pluck('gender');

    //     $employeeTypes = Employee::distinct('employee_type')->pluck('employee_type');

    //     $positions = Employee::distinct('position')->pluck('position');

    //     $nationalities = Employee::distinct('nationality')->pluck('nationality');

    //     $basedAtPlaces = Employee::distinct('based_at')->pluck('based_at');

    //     $response = [
    //         'employees' => $employees,
    //         'genders' => $genders,
    //         'employeeTypes' => $employeeTypes,
    //         'positions' => $positions,
    //         'nationalities' => $nationalities,
    //         'basedAtPlaces' => $basedAtPlaces,
    //     ];

    //     return response($response, 201);

    // }

    // public function getDateTitle($request)
    // {
    //     if ($request->dateType == 'custom_date') {
    //         return 'From ' . $request->fromDate . " To " . $request->toDate;
    //     } else if ($request->dateType == 'last_week') {
    //         return 'From ' . Carbon::now()->subDays(7)->format('Y-m-d') . " To " . Carbon::now()->format('Y-m-d');
    //     } else if ($request->dateType == 'last_month') {
    //         return 'From ' . Carbon::now()->startOfMonth()->format('Y-m-d') . " To " . Carbon::now()->endOfMonth()->format('Y-m-d');
    //     } else if ($request->dateType == 'all_time') {
    //         return 'All Time';
    //     }


    // }

    // public function exportExcel(Request $request)
    // {

    //     $formArray = array(
    //         $request->selectedEmployees,
    //         $request->dateType,
    //         $request->fromDate,
    //         $request->toDate,

    //     );

    //     return Excel::download(new EmployeeSalaryExpenseDeductionExport($formArray), 'employees.xlsx');

    // }

    // public function exportPdf(Request $request)
    // {

    //     // date calculation
    //     $now = Carbon::now();
    //     $lastWeekStartDate = Carbon::now()->subDays(7);
    //     $lastWeekEndDate = $now->format('Y-m-d');
    //     $lastMonthStartDate = $now->startOfMonth()->format('Y-m-d');
    //     $lastMonthEndDate = $now->endOfMonth()->format('Y-m-d');
    //     // date calculation

    //     $title = 'Employee Amount Report'; // Report title

    //     $meta = [ // For displaying filters description on header
    //         'Date' => $this->getDateTitle($request),
    //         'Employees number' => count(Helper::getArrayFromString($request->selectedEmployees)),

    //     ];

    //     if ($request->dateType == 'custom_date') {
    //         $queryBuilder = Employee::whereIn('id', Helper::getArrayFromString($request->selectedEmployees))->
    //             where('created_at', '>', $request->fromDate ? $request->fromDate : "2020-11-28")->where('created_at', '<', $request->toDate ? $request->toDate : $now->endOfWeek()->format('Y-m-d'))->orderBy('created_at', "DESC")

    //             ->with(['expenses', 'deductions']);

    //     } else if ($request->dateType == 'last_week') {
    //         $queryBuilder = Employee::whereIn('id', Helper::getArrayFromString($request->selectedEmployees))->
    //             where('created_at', '>', $lastWeekStartDate)->where('created_at', '<', $lastWeekEndDate)->orderBy('created_at', "DESC")

    //             ->with(['expenses', 'deductions']);
    //     } else if ($request->dateType == 'last_month') {
    //         $queryBuilder = Employee::whereIn('id', Helper::getArrayFromString($request->selectedEmployees))->
    //             where('created_at', '>', $lastMonthStartDate)->where('created_at', '<', $lastMonthEndDate)->orderBy('created_at', "DESC")

    //             ->with(['expenses', 'deductions']);
    //     } else if ($request->dateType == 'all_time') {
    //         $queryBuilder = Employee::whereIn('id', Helper::getArrayFromString($request->selectedEmployees))->
    //             orderBy('created_at', "DESC")

    //             ->with(['expenses', 'deductions']);
    //     }

    //     $columns = [
    //         'Name' => 'first_name',
    //         'Position' => 'position',
    //         'based_at' => 'based_at',
    //         'Total Salary' => 'total_salary',
    //         'Total expenses' => function ($result) { // You can do if statement or any action do you want inside this closure
    //             $this->totalExpenses = 0;
    //             $expenses = $result->expenses;
    //             foreach ($expenses as $expense) {
    //                 $this->totalExpenses += (int) $expense->total;
    //             }

    //             return $this->totalExpenses ? $this->totalExpenses : 0;

    //         },

    //         'Total Deductions' => function ($result) { // You can do if statement or any action do you want inside this closure
    //             $bouns = $result->deductions;

    //             foreach ($bouns as $boun) {
    //                 $this->totalBouns += (int) $boun->total;
    //             }

    //             return $this->totalBouns ? $this->totalBouns : 0;

    //         },

    //         'Total amount' => function ($result) { // You can do if statement or any action do you want inside this closure
    //             return $this->totalBouns + $this->totalExpenses + (int) $result->total_salary;

    //         },
          

    //     ];

    //     // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
    //     return PdfReport::of($title, $meta, $queryBuilder, $columns)->setPaper('a3')->editColumn('Total', [
    //         'class' => 'bold',
    //     ])

    //         ->download('employees'); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()

    // }

    // public function charts()
    // {

    //     $authArray = array('report', 'show');

    //     Helper::authorizeModel($authArray);

    //     return view('charts');

    // }

    


}
