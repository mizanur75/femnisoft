@extends('web.layouts.app')
@section('title','Online Health Service')

@push('css')
@endpush

@section('content')
<!-- slider -->

    

    <!-- Appoint -->
    @include('web.include.appoint')



    <!-- Services -->
    @include('web.include.services')


    @include('web.include.testimonial')

    @include('web.include.blog')
@endsection

@push('css')
@endpush