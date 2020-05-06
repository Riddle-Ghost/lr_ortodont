<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // User
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->on('roles')->references('id');
        });

        // ClinicInfo
        Schema::table('clinic_infos', function (Blueprint $table) {
            $table->foreign('user_id')->on('users')->references('id');
        });

        // DoctorInfo
        Schema::table('doctor_infos', function (Blueprint $table) {
            $table->foreign('user_id')->on('users')->references('id');
        });

        // Doctor-Clinic
        Schema::table('doctor_clinic', function (Blueprint $table) {
            $table->foreign('doctor_id')->on('users')->references('id');
            $table->foreign('clinic_id')->on('users')->references('id');
        });

        // Order
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('clinic_id')->on('users')->references('id');
            $table->foreign('doctor_id')->on('users')->references('id');
            $table->foreign('order_status_id')->on('order_statuses')->references('id');
            $table->foreign('payment_id')->on('payments')->references('id');
            $table->foreign('patient_id')->on('patients')->references('id');
        });

        // TeethModel
        Schema::table('teeth_models', function (Blueprint $table) {
            $table->foreign('order_id')->on('orders')->references('id');
        });

        // OrderMessage
        Schema::table('order_messages', function (Blueprint $table) {
            $table->foreign('order_id')->on('orders')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
