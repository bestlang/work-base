<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sniper_employee_departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('部门名称');
//            $table->unsignedBigInteger('parent_id')->nullable()->comment('上级部门');
            $table->string('manager')->comment('部门经理')->nullable();
            $table->nestedSet();
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sniper_employee_departments');
    }
}
