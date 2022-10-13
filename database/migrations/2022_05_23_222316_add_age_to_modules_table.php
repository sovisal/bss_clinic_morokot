<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgeToModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('echographies', function (Blueprint $table) {
            $table->string('age', 3)->default('0');
        });
        Schema::table('ecgs', function (Blueprint $table) {
            $table->string('age', 3)->default('0');
        });
        Schema::table('xrays', function (Blueprint $table) {
            $table->string('age', 3)->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('echographies', function (Blueprint $table) {
            $table->dropColumn('age');
        });
        Schema::table('ecgs', function (Blueprint $table) {
            $table->dropColumn('age');
        });
        Schema::table('xrays', function (Blueprint $table) {
            $table->dropColumn('age');
        });
    }
}
