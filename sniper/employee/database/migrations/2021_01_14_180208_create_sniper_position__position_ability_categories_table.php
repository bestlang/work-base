<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperPositionPositionAbilityCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //职位 - 能力分类-关系表
        Schema::create('sniper_position__position_ability_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('position_id')->comment('职位ID');
            $table->unsignedBigInteger('ability_category_id')->comment('能力分类ID');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sniper_position__position_ability_categories');
    }
}
