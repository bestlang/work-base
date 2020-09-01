<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BaumUpdatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('show_name')->comment('权限显示名');
            $table->unsignedInteger('parent_id')->default(0);
            $table->integer('left')->default(0);
            $table->integer('right')->default(0);
            $table->integer('depth')->default(0);
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('show_name');
            $table->dropColumn('parent_id');
            $table->dropColumn('left');
            $table->dropColumn('right');
            $table->dropColumn('depth');
        });
    }
}
