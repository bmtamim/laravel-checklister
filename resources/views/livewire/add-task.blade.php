<div class="add-task-form-wrapper">
    <form wire:submit.prevent="store" action="{{ route('admin.checklists.tasks.store',$checklist) }}" method="POST"
          enctype="multipart/form-data">
        @csrf
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
                <label for="taskName">{{ __('Name') }}</label>
                <input wire:model.defer="name" type="text" class="form-control" id="taskName" name="name"
                       placeholder="{{ __('Enter Task Name') }}" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="taskDesc">{{ __('Description') }}</label>
                <textarea wire:model.defer="description" name="description" id="taskDesc" rows="5"
                          class="form-control">{{ old('description') }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
    </form>
</div>