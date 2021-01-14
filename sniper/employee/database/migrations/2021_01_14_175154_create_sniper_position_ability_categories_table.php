<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperPositionAbilityCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //能力分类
        Schema::create('sniper_position_ability_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('能力分类名')->nullable();
            $table->unsignedBigInteger('position_id')->comment('职位ID')->nullable();
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
        Schema::dropIfExists('sniper_position_ability_categories');
    }
}
