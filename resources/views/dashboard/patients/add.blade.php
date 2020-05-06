@extends('layouts.dashboard')

@section('content')
    <section id="patient-add">
        <div class="container">
            @include('dashboard.nav')
            <div class="content" id="react-db-add-patient-page"></div>
        </div>
    </section>
@endsection