<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeesSalariesExpensesDeductionsResource extends JsonResource
{

    public function __construct($resource)
    {
        // Ensure we call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource; // $apple param passed
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        $deductionsTotal = 0 ;
        $deductions = $this->deductions ;
        foreach ( $deductions as $deduction) {
            $deductionsTotal += (int)$deduction->total;
        }

        $expensesTotal = 0 ;
        $expenses = $this->expenses ;
        foreach ( $expenses as $expense) {
            $expensesTotal += (int)$expense->total;
        }






        return [
            'First_name' => $this->first_name . $this->last_name,
            'position' => $this->position,
            'based_at' => $this->based_at,
            'Salary Total' => $this->total_salary,
            'Expenses Total' => $expensesTotal ? $expensesTotal : 0 ,
            'Deductions Total' => $deductionsTotal ? $deductionsTotal : 0 ,
            'Total' => (int)$this->total_salary +   $expensesTotal + $deductionsTotal ,

        ];
    }
}
