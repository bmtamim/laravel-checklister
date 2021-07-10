@extends('layouts.app')

@section('title')
{{ __('Edit Page') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-0">{{ __('Edit Page') }}</h4>
            </div>
            <form action="{{ route('admin.pages.update',$page) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                    @if(session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                    @endif
                    <div class="form-group">
                        <label for="title">{{ __('Title') }}</label>
                        <input type="text" class="form-control" id="title" name="title"
                               placeholder="{{ __('Enter Title') }}" value="{{ $page->title ?? old('title') }}">
                    </div>
                    <div class="form-group">
                        <label for="body">{{ __('Body') }}</label>
                        <textarea name="body" id="body" rows="5"
                                  class="form-control">{{  $page->body ?? old('body') }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .then( editor => {
            editor.ui.view.editable.element.style.height = '300px';
         } )
        .catch( error => {
            console.error( error );
        } );
</script>
@endpush