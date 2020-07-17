<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message')->nullable();
            $table->text('short_message')->nullable();
            $table->boolean('to_email')->default(false);
            $table->boolean('to_db')->default(false);
            $table->timestamp('mailed_at')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedInteger('min_balance')->default(0);
            $table->unsignedInteger('max_balance')->default(0);
            $table->json('roles')->nullable();
            $table->timestamp('created_from')->nullable();
            $table->timestamp('created_to')->nullable();
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
        Schema::dropIfExists('mailings');
    }
}
