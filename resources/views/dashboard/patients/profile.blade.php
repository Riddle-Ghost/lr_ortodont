@extends('layouts.dashboard')

@section('content')
    <section id="patient-card">
        <div class="container">
            @include('dashboard.nav')
            <div class="content" id="react-db-patient-profile-page" data-patient-id="{{ $patientId }}"></div>
        </div>
    </section>
@endsection