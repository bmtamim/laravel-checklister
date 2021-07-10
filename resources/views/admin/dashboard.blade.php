@extends('layouts.app')

@section('title','Dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    {{ __('This is Admin Dashboard') }}
                </div>
            </div>
        </div>
    </div>
@endsection
