<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@index');

Auth::routes([
    'register'  => false,
    'verify'    => true
]);

Route::prefix('/dashboard')->namespace('Dashboard')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index');

    Route::prefix('/doctors')->group(function () {
        Route::get('/', 'DoctorController@index')->name('dashboard.doctors');
        Route::get('/add', 'DoctorController@add')->name('dashboard.doctors.add');
        Route::get('/profile/{doctorId}', 'DoctorController@profile')->name('dashboard.doctors.profile');
        Route::get('/edit/{doctorId}', 'DoctorController@edit')->name('dashboard.doctors.edit');
    });

    Route::prefix('/clinics')->group(function () {
        Route::get('/add', 'ClinicController@add')->name('dashboard.clinics.add');
        Route::get('/profile/{clinicId}', 'ClinicController@profile')->name('dashboard.clinics.profile');
        Route::get('/edit/{clinicId}', 'ClinicController@edit')->name('dashboard.clinics.edit');
    });

    Route::prefix('/patients')->group(function () {
        Route::get('/add', 'PatientController@add')->name('dashboard.patients.add');
        Route::get('/profile/{patientId}', 'PatientController@profile')->name('dashboard.patients.profile');
        Route::get('/edit/{patientId}', 'PatientController@edit')->name('dashboard.patients.edit');
    });
});

Route::prefix('/office')->namespace('Office')->group(function () {
    Route::get('/', 'OfficeController@index')->name('office.index');

    Route::prefix('/clinic/{clinicId}')->group(function () {
        Route::get('/', 'OfficeController@clinic')->name('office.clinic');

        Route::prefix('/patients')->group(function () {
            Route::get('/add', 'PatientController@add')->name('office.patients.add');
            Route::get('/{patientId}', 'PatientController@profile')->name('office.patients.profile');
        });
    });
});

Route::prefix('/cabinet')->namespace('Cabinet')->group(function () {
    Route::get('/', 'CabinetController@index')->name('cabinet.index');
});

Route::prefix('/api')->namespace('API')->group(function () {
    Route::prefix('/doctor')->group(function () {
        Route::get('/', 'DoctorController@index');
        Route::post('/', 'DoctorController@store');
        Route::get('/{doctor}/clinic', 'DoctorController@getClinics');
        Route::post('/{doctor}/clinic', 'DoctorController@addClinic');
        Route::delete('/{doctor}/clinic/{clinic}', 'DoctorController@removeClinic');
        Route::get('/{doctor}', 'DoctorController@show');
        Route::put('/{doctor}', 'DoctorController@update');
    });

    Route::prefix('/clinic')->group(function () {
        Route::get('/', 'ClinicController@index');
        Route::get('/{clinic}/doctors', 'ClinicController@getDoctors');
        Route::get('/{clinic}', 'ClinicController@show');
        Route::post('/', 'ClinicController@store');
        Route::put('/{clinic}', 'ClinicController@update');
    });

    Route::prefix('/order')->group(function () {
        Route::get('/', 'OrderController@index');
        Route::get('/{order}', 'OrderController@show');
        Route::post('/', 'OrderController@store');
    });
});