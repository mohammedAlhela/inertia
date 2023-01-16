<?php

namespace Database\Seeders;

use App\Models\Deduction;
use App\Models\Expense;
use Illuminate\Database\Seeder;

class ExpenseDeductionCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $expenses = Expense::all();
        $deductions = Deduction::all();

        foreach ($expenses as $expense) {
            $expense->code = "EXP-$expense->employee_id-$expense->id";

            $expense->save();
        }

        foreach ($deductions as $deduction) {
            $deduction->code = "DED-$deduction->employee_id-$deduction->id";

            $deduction->save();
        }

    }
}
