@extends('layouts.base', ['title' => 'Register'])
@push('styles')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endpush

@section('content')
@include('components.register')
@endsection