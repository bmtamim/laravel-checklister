@extends('layouts.app')

@section('title')
    {{ ucfirst(str_replace('_',' ',$list_type)) }}
@endsection
@push('styles')
    <style>
        img {
            max-width: 100% !important;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @livewire('checklist-show',['list_type'=>$list_type])
        </div>
    </div>
@endsection
