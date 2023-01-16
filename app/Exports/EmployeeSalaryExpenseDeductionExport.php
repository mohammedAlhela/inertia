<?php

namespace App\Exports;

use App\Models\Employee;
use App\Http\Resources\EmployeesSalariesExpensesDeductionsResource;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use Helper;

class EmployeeSalaryExpenseDeductionExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{



    public $formArray;

    public function __construct($formArray)
    {
        $this->formArray = $formArray;
    }


    public function collection()
    {


           // date calculation
           $now = Carbon::now();
           $lastWeekStartDate = $now->subDays(7)->format('Y-m-d');
           $lastWeekEndDate = $now->format('Y-m-d');
           $lastMonthStartDate = $now->startOfMonth()->format('Y-m-d');
           $lastMonthEndDate = $now->endOfMonth()->format('Y-m-d');
           // date calculation


           if ($this->formArray[1] == 'custom_date') {
            $employees = collect(EmployeesSalariesExpensesDeductionsResource::collection(Employee::whereIn('id', Helper::getArrayFromString($this->formArray[0]))->
                where('created_at', '>', $this->formArray[2] ? $this->formArray[2] : "1000-11-28")->where('created_at', '<', $this->formArray[3] ? $this->formArray[3] : $now->endOfWeek()->format('Y-m-d'))->orderBy('created_at', "DESC")

                ->with(['expenses', 'deductions'])->get()));

        } else if ($this->formArray[1] == 'last_week') {
            $employees = collect(EmployeesSalariesExpensesDeductionsResource::collection(Employee::whereIn('id', Helper::getArrayFromString($this->formArray[0]))->
                where('created_at', '>', $lastWeekStartDate)->where('created_at', '<', $lastWeekEndDate)->orderBy('created_at', "DESC")

                ->with(['expenses', 'deductions'])->get()));
        } else if ($this->formArray[1] == 'last_month') {
            $employees = collect(EmployeesSalariesExpensesDeductionsResource::collection(Employee::whereIn('id', Helper::getArrayFromString($this->formArray[0]))->
                where('created_at', '>', $lastMonthStartDate)->where('created_at', '<', $lastMonthEndDate)->orderBy('created_at', "DESC")

                ->with(['expenses', 'deductions'])->get()));
        } else if ($this->formArray[1] == 'all_time') {
            $employees = collect(EmployeesSalariesExpensesDeductionsResource::collection(Employee::whereIn('id', Helper::getArrayFromString($this->formArray[0]))->
                orderBy('created_at', "DESC")

                ->with(['expenses', 'deductions'])->get()));
        }



        return $employees;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Position',
            'Based At',
            'Total salary',
            'Total expenses',
            'Total Deductions',
            'Total',

        ];
    }

    // ...

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont('arial')->setSize(16);
            },

        ];
    }
}
