<table class="table table-responsive-sm">
    <thead>
    <tr>
        <th>Order</th>
        <th>#</th>
        <th>Name</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody wire:sortable="updateTaskOrder">
    @foreach($tasks as $key => $task)
        <tr>
            <td style="width: 50px">
                @if($task->order > 1)
                    <a wire:click.prevent="taskOrderUp({{ $task->id }})" href="" style="font-size: 18px;color: #222222">&uarr;</a>
                @endif
                @if($task->order < $tasks->max('order'))
                    <a wire:click.prevent="taskOrderDown({{ $task->id }})" href=""
                       style="font-size: 18px;color: #222222">&darr;</a>
                @endif
            </td>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $task->name ?? __('Task Name') }}</td>
            <td>
                <a href="{{ route('admin.checklists.tasks.edit',[$checklist,$task]) }}"
                   class="btn btn-info btn-sm">Edit</a>
                <button class="btn btn-danger btn-sm"
                        onclick="event.preventDefault(); document.getElementById('delete-task-form-{{ $task->id }}').submit();">{{ __('Delete') }}</button>
                <form id="delete-task-form-{{ $task->id }}"
                      action="{{ route('admin.checklists.tasks.destroy',[$checklist,$task]) }}" method="post"
                      class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
