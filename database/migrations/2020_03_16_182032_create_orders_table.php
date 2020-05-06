<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price')->default(0);
            $table->float('paid')->default(0);
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('order_status_id');
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('patient_id');
            $table->json('recipe');
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
        Schema::dropIfExists('orders');
    }
}
