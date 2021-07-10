@extends('layouts.app')

@section('title')
    {{ $checklist->name ?? __('Default') }}
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
            @livewire('header-total-count',['checklist_group_id'=>$checklist->checklist_groups_id])
            @livewire('checklist-show',['checklist'=>$checklist])
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        let taskDescToggle = document.querySelectorAll('.task-desc-toggle');
        taskDescToggle.forEach(function (item, index) {
            item.addEventListener('click', function () {
                let taskId = this.dataset.task;
                let taskDesc = document.getElementById('task-desc-' + taskId);
                taskDesc.classList.toggle('d-none');
                item.querySelector('#task-toggle-bottom').classList.toggle('d-none');
                item.querySelector('#task-toggle-top').classList.toggle('d-none');
            });
        });
    </script>
@endpush
