<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeDepartmentsArchive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sniper_employee_departments_archive', function (Blueprint $table) {
            $table->unsignedBigInteger('archive_id')->default(1)->comment('存档编号');
            $table->unsignedBigInteger('id');
            $table->string('name')->comment('部门名称');
            $table->string('manager')->comment('部门经理')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('left')->nullable();
            $table->unsignedBigInteger('right')->nullable();
            $table->integer('depth')->nullable();
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
        Schema::dropIfExists('sniper_employee_departments_archive');
    }
}
