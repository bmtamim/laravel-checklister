@extends('layouts.app')
@section('title')
{{ $page->title }}
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ $page->title }}</div>

            <div class="card-body">
                {!! $page->body !!}
            </div>
        </div>
    </div>
</div>
@endsection