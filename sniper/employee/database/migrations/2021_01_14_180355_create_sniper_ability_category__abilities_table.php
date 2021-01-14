<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSniperAbilityCategoryAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //能力分类 - 能力 关系表
        Schema::create('sniper_ability_category__abilities', function (Blueprint $table) {
            $table->unsignedBigInteger('ability_category_id')->comment('能力分类ID');
            $table->unsignedBigInteger('ability_id')->comment('能力ID');
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
        Schema::dropIfExists('sniper_ability_category__abilities');
    }
}
