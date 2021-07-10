<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ $list_name ?? __('Default') }}</div>
            <div class="card-body">
                <table class="table">
                    @foreach($list_tasks as $task)
                        @if($loop->iteration == 6 && !auth()->user()->has_free_access && !auth()->user()->subscribed('primary'))
                            <tr>
                                <td colspan="3" class="text-center">
                                    <h4>{{ __('You are limited at 5 tasks per checklist') }}.</h4>
                                    <a href="{{ route('users.packages') }}"
                                       class="btn btn-primary">{{ __('Unlock all now') }}</a>
                                </td>
                            </tr>
                        @elseif($loop->iteration <= 5 || auth()->user()->has_free_access || auth()->user()->subscribed('primary'))
                            <tr>
                                <td style="width: 50px">
                                    <input wire:click="complete_task({{ $task->id }})"
                                           @if(in_array($task->id, $completed_task_id)) checked="checked"
                                           @endif type="checkbox">
                                </td>
                                <td><a wire:click.prevent="toggle_task({{ $task->id }})" href="#"
                                       class="text-black-50 text-decoration-none">{{ $task->name ?? __('Default') }}</a>
                                </td>
                                <td style="width: 50px">
                                    @if(!empty($opened_task) && $opened_task == $task->id)
                                        <i wire:click.prevent="toggle_task({{ $task->id }})" class="cil-caret-top"></i>
                                    @else
                                        <i wire:click.prevent="toggle_task({{ $task->id }})"
                                           class="cil-caret-bottom"></i>
                                    @endif
                                </td>
                            </tr>
                            @if(!empty($opened_task) && $opened_task == $task->id)
                                <tr>
                                    <td style="width: 50px"></td>
                                    <td colspan="2">
                                        {!! $task->description !!}
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        @if(!is_null($current_task))
            <div class="card">
                <div class="card-body">
                    &#9788;

                    @if($current_task->add_to_my_day)
                        <a wire:click.prevent="add_to_my_day({{ $current_task->id }})"
                           href="">{{ __('Remove from My Day') }}</a>
                    @else
                        <a wire:click.prevent="add_to_my_day({{ $current_task->id }})"
                           href="">{{ __('Add to My Day') }}</a>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if($current_task->is_important)
                        <a wire:click.prevent="add_to_important({{ $current_task->id }})"
                           href="">&starf; {{ __('Important') }}</a>
                    @else
                        <a wire:click.prevent="add_to_important({{ $current_task->id }})"
                           href="">&star; {{ __('Important') }}</a>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if($current_task->reminder_at)
                        &#9745;  Reminder At {{ $current_task->reminder_at->format('M j, Y H:i') }} <a
                            wire:click.prevent="set_reminder_at({{ $current_task->id }})"
                            href="#">{{ __('Remove') }}</a></li>
                    @else
                        <a wire:click.prevent="toggle_reminder_at({{ $current_task->id }})"
                           href="#">&#9745; {{ __('Add Reminder At') }}</a>
                        @if(!is_null($reminder_at_opened) && $reminder_at_opened == $current_task->id)
                            <ul>
                                <li>
                                    <a wire:click.prevent="set_reminder_at({{ $current_task->id }},'{{ today()->addDay()->toDateString() }}')"
                                       href="#">{{ __('Tomorrow') }} {{ date('H') }}:00</a></li>
                                <li>
                                    <a wire:click.prevent="set_reminder_at({{ $current_task->id }},'{{ today()->addWeek()->startOfWeek()->toDateString() }}')"
                                       href="#">{{ __('Next Week') }} {{ date('H') }}:00</a></li>
                                <li>{{ __('Or pick a date') }}
                                    <div class="row no-gutters">
                                        <div class="col-lg-7 py-1 pr-1">
                                            <input class="form-control" wire:model.prevent="reminder_at_date"
                                                   type="date"
                                                   name="due_date_picker">
                                        </div>
                                        <div class="col-lg-5 py-1 pl-1">
                                            <select class="form-control" wire:model.prevent="reminder_at_hour">
                                                @foreach(range(0,23) as $hour)
                                                    <option value="{{ $hour }}"> {{ $hour }} : 00</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-12 mt-1">
                                            <button
                                                wire:click.prevent="set_reminder_at({{ $current_task->id }},'custom')"
                                                class="btn btn-primary">Save
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        @endif
                    @endif

                    <hr>
                    @if($current_task->due_date)
                        &#9745;  DUE {{ $current_task->due_date->format('M j, Y') }} <a
                            wire:click.prevent="set_due_date({{ $current_task->id }})"
                            href="#">{{ __('Remove') }}</a></li>
                    @else
                        <a wire:click.prevent="toggle_due_date({{ $current_task->id }})"
                           href="#">&#9745; {{ __('Add due date') }}</a>
                        @if(!is_null($due_date_opened) && $due_date_opened == $current_task->id)
                            <ul>
                                <li>
                                    <a wire:click.prevent="set_due_date({{ $current_task->id }},'{{ today()->addDay()->toDateString() }}')"
                                       href="#">{{ __('Tomorrow') }}</a></li>
                                <li>
                                    <a wire:click.prevent="set_due_date({{ $current_task->id }},'{{ today()->addWeek()->startOfWeek()->toDateString() }}')"
                                       href="#">{{ __('Next Week') }}</a></li>
                                <li>{{ __('Or pick a date') }}
                                    <br>
                                    <input wire:model.prevent="due_date_picker" type="date" name="due_date_picker"
                                           class="form-control">
                                </li>
                            </ul>
                        @endif
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
