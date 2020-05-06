@extends('layouts.dashboard')

@section('content')
    <section id="doc-list">
        <div class="container">
            @include('dashboard.nav')
            <div class="content" id="react-db-doctors-page"></div>
        </div>
    </section>
@endsection