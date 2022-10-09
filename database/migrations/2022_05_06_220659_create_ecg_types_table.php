<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcgTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecg_types', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_kh')->nullable();
            $table->string('price', 10)->default(0);
            $table->integer('index')->default(99999);
            $table->text('attribite')->nullable();
            $table->text('default_form')->nullable();
            $table->integer('status')->default(1);
            $table->text('other')->nullable();
            $table->timestamps();
        });

        // Insert some stuff
        DB::table('ecg_types')->insert([
            [
                'name_en' => 'ECG',
                'name_kh' => 'ECG',
                'index' => 1
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecg_types');
    }
}
