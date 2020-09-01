<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraColumnToCmsFieldTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cms_field_types', function (Blueprint $table) {
            $table->string('extra', 5000)->nullable()->comment('附加信息');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cms_field_types', function (Blueprint $table) {
            $table->dropColumn('extra');
        });
    }
}
