<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeeDingDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('proxy')->create('sniper_employee_ding_departments', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('name')->nullable();
            $table->string('parentid')->nullable();
            $table->string('createDeptGroup')->nullable();
            $table->string('autoAddUser')->nullable();
            $table->text('ext')->nullable();

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
        Schema::connection('proxy')->dropIfExists('sniper_employee_ding_departments');
    }
}
