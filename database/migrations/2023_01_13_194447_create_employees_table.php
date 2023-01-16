<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();


            $table->string('first_name');
            $table->string('last_name');
            $table->string('image')->nullable();
            $table->string('employee_type');
            $table->string('email');
            $table->string('phone_number');
            $table->string('nationality')->nullable();
            $table->string('gender')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('local_mobile_number')->nullable();
            $table->mediumText('local_address')->nullable();
            $table->string('emergency_number')->nullable();
            $table->string('emergency_contact_name')->nullable();

            $table->string('passport_number')->nullable();
            $table->string('passport_expiry_date')->nullable();

            $table->string('residency_number')->nullable();
            $table->string('residency_expiry_date')->nullable();

            $table->string('health_number')->nullable();
            $table->string('health_renewal_date')->nullable();

            $table->string('labour_contract')->nullable();
            $table->string('labout_contract_issue_date')->nullable();
            $table->string('labour_contract_expiry_date')->nullable();

            $table->string('position')->nullable();
            $table->string('position_date_of_joining')->nullable();
            $table->string('position_branch_number')->nullable();

            $table->string('based_at')->nullable();
            $table->string('based_at_started_date')->nullable();
            $table->string('based_at_current_status')->nullable();

            $table->string('basic_salary')->default('0');
            $table->string('salary_transportation')->default('0');
            $table->string('salary_accommodation')->default('0');
            $table->string('total_salary')->default('0');

            $table->string('date_of_leaving')->nullable();
            $table->mediumText('reason_of_leaving')->nullable();

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
        Schema::dropIfExists('employees');
    }
}
