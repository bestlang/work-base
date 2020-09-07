<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperEmployeePositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sniper_employee_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('职务名称');
            $table->unsignedBigInteger('department_id')->comment('所属部门ID');
//            $table->unsignedBigInteger('parent_id')->comment('上级职务')->nullable();
            $table->nestedSet();
            $table->integer('desiring')->comment('所需员工数')->default(0);
            $table->text('jd')->nullable()->comment('工作描述');
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
            Schema::dropIfExists('sniper_employee_positions');
    }
}
