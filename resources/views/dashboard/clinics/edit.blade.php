@extends('layouts.dashboard')

@section('content')
    <section id="clinic-profile-edit">
        <div class="container">
            @include('dashboard.nav')
            <div class="content" id="react-db-edit-clinic-page" data-clinic-id="{{ $clinicId }}"></div>
        </div>
    </section>
@endsection

@push('modals')
    @include('modals.admin-choose-doctors', [ 'clinicId' => $clinicId, 'mode' => 1 ])
@endpush