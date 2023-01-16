<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->integer('employee_id');
            $table->string('date')->default(now());
            $table->mediumText('details')->nullable();
            $table->mediumText('notes')->nullable();
            $table->string('deduction')->default(0);
            $table->string('bouns')->default(0);
            $table->string('salary_payments')->default(0);
            $table->string('total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deductions');
    }
}
