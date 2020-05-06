@extends('layouts.dashboard')

@section('content')
    <section id="doc-profile-edit">
        <div class="container">
            @include('dashboard.nav')
            <div class="content" id="react-db-edit-doctor-page" data-doctor-id="{{ $doctorId }}"></div>
        </div>
    </section>
@endsection