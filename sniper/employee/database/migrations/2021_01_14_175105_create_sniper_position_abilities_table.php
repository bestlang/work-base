<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperPositionAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //能力表
        Schema::create('sniper_position_abilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->comment('能力分类ID')->nullable();
            $table->string('name')->comment('能力名')->nullable();
            $table->text('detail')->comment('能力详情')->nullable();
            $table->smallInteger('totalScore')->comment('能力分值')->default(0);
            $table->smallInteger('okScore')->comment('达标分值')->default(0);
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
        Schema::dropIfExists('sniper_position_abilities');
    }
}
