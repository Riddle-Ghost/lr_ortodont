<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic');
            $table->boolean('sex');
            $table->date('birthday');
            $table->text('diagnosis');
            $table->text('photo_profile');
            $table->text('photo_fullface_smile');
            $table->text('photo_fullface_without_smile');
            $table->text('photo_occlusar_up');
            $table->text('photo_occlusar_down');
            $table->text('photo_lateral_left');
            $table->text('photo_front');
            $table->text('photo_lateral_right');
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
        Schema::dropIfExists('patients');
    }
}
