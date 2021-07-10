@extends('layouts.app')

@section('title')
{{ __('Add Checklist Groups') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('admin.checklist_groups.store') }}" method="post">
                @csrf
                <div class="card-header">
                    <h4 class="m-0">{{ __('Add Checklist Group') }}</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            {{ $error }}
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="{{ __('Enter Checklist name') }}" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection