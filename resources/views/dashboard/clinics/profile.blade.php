@extends('layouts.dashboard')

@section('content')
    <section id="clinic-profile">
        <div class="container">
            @include('dashboard.nav')
            <div class="content" id="react-db-clinic-profile-page" data-clinic-id="{{ $clinicId }}"></div>
        </div>
    </section>
@endsection

@push('modals')
    @include('modals.admin-choose-doctors', [ 'clinicId' => $clinicId, 'mode' => 0 ])
@endpush