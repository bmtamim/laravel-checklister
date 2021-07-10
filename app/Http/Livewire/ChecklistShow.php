<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChecklistShow extends Component
{
    public $checklist;
    public $list_type;
    public $list_name;
    public $list_tasks;
    public $completed_task_id = [];
    public $user_tasks;
    public $opened_task;
    public ?\App\Models\Task $current_task;

    public $due_date_opened = null;
    public $due_date_picker;
    public $reminder_at_opened = null;
    public $reminder_at_date;
    public $reminder_at_hour;

    protected $listeners = ['complete_task' => 'render'];


    public function mount()
    {
        $this->current_task = null;
    }

    public function render()
    {
        if (is_null($this->list_type)) {
            $this->list_name = $this->checklist->name;
            $this->list_tasks = $this->checklist->tasks->where('user_id', null);
            $this->user_tasks = $this->checklist->user_tasks;
            $this->completed_task_id = $this->user_tasks->whereNotNull('completed_at')->pluck('task_id')->toArray();
        } else {
            switch ($this->list_type) {
                case 'my_day';
                    $this->user_tasks = \App\Models\Task::query()->where('user_id', Auth::id())->whereNotNull('add_to_my_day')->get();
                    break;
                case 'important';
                    $this->user_tasks = \App\Models\Task::query()->where(['user_id' => Auth::id(), 'is_important' => true])->get();
                    break;
                case 'planned';
                    $this->user_tasks = \App\Models\Task::query()->where('user_id', Auth::id())->whereNotNull('due_date')->get();
                    break;
                default :
                    abort(404);
            }
            $this->list_tasks = \App\Models\Task::whereIn('id', $this->user_tasks->pluck('task_id')->toArray())->get();
            $this->completed_task_id = $this->user_tasks->whereNotNull('completed_at')->pluck('task_id')->toArray();
        }

        return view('livewire.checklist-show');
    }

    public function toggle_task($task_id)
    {
        if ($this->opened_task == $task_id) {
            $this->opened_task = '';
            $this->current_task = null;
        } else {
            $this->opened_task = $task_id;
            $this->current_task = \App\Models\Task::where(['user_id' => Auth::id(), 'task_id' => $task_id])->first();

            if (!$this->current_task) {
                $task = \App\Models\Task::find($task_id);
                $create_task = $task->replicate();
                $create_task->user_id = Auth::id();
                $create_task->task_id = $task_id;
                $create_task->save();
                $this->current_task = $create_task;
            }
        }
    }

    public function complete_task($task_id)
    {
        $task = \App\Models\Task::query()->find($task_id);
        if ($task) {
            $user_task = \App\Models\Task::query()->where('user_id', auth()->id())->where('task_id', $task->id)->first();
            if ($user_task) {
                if (is_null($user_task->completed_at)) {
                    $user_task->update(['completed_at' => Carbon::now()]);
                    $this->completed_task_id[] = $task->id;
                    $this->emit('complete_task', $task->checklist_id);
                } else {
                    $user_task->update(['completed_at' => null]);
                    $this->emit('complete_task', $task->checklist_id);
                }
            } else {
                $user_task = $task->replicate();
                $user_task->user_id = auth()->id();
                $user_task->task_id = $task->id;
                $user_task->completed_at = Carbon::now();
                $user_task->save();
                $this->emit('complete_task', $task->checklist_id);
            }
        }
    }

    public function add_to_my_day($task_id)
    {
        $user_task = \App\Models\Task::where(['user_id' => Auth::id(), 'id' => $task_id])->first();
        if ($user_task) {
            if (is_null($user_task->add_to_my_day)) {
                $user_task->update(['add_to_my_day' => Carbon::now()]);
                $this->emit('user_task_counter_change', 'my_day');
            } else {
                $user_task->update(['add_to_my_day' => null]);
                $this->emit('user_task_counter_change', 'my_day', -1);
            }
        } else {
            $task = \App\Models\Task::find($task_id);
            $user_task = $task->replicate();
            $user_task->user_id = Auth::id();
            $user_task->task_id = $task->id;
            $user_task->add_to_my_day = Carbon::now();
            $user_task->save();
            $this->emit('user_task_counter_change', 'my_day');
        }
        $this->current_task = $user_task;
    }

    public function add_to_important($task_id)
    {
        $user_task = \App\Models\Task::where(['user_id' => Auth::id(), 'id' => $task_id])->first();
        if ($user_task) {
            if (!$user_task->is_important) {
                $user_task->update(['is_important' => true]);
                $this->emit('user_task_counter_change', 'important');
            } else {
                $user_task->update(['is_important' => false]);
                $this->emit('user_task_counter_change', 'important', -1);
            }
        } else {
            $task = \App\Models\Task::find($task_id);
            $creat_user_task = $task->replicate();
            $creat_user_task->user_id = Auth::id();
            $creat_user_task->task_id = $task->id;
            $creat_user_task->is_important = true;
            $creat_user_task->save();
            $this->emit('user_task_counter_change', 'is_important');
        }
        $this->current_task = $user_task;
    }

    public function toggle_due_date($task_id)
    {
        if ($this->due_date_opened == $task_id) {
            $this->due_date_opened = null;
        } else {
            $this->due_date_opened = $task_id;
        }
    }

    public function set_due_date($task_id, $date = null)
    {
        $user_task = \App\Models\Task::query()->where(['user_id' => Auth::id(), 'id' => $task_id])->first();
        if ($user_task) {
            if ($user_task->due_date) {
                $user_task->update(['due_date' => null]);
                $this->emit('user_task_counter_change', 'planned', -1);
            } else {
                $user_task->update(['due_date' => $date]);
                $this->emit('user_task_counter_change', 'planned');
            }
        } else {
            $task = \App\Models\Task::find($task_id);
            $user_task = $task->replicate();
            $user_task->user_id = Auth::id();
            $user_task->task_id = $task->id;
            $user_task->due_date = Carbon::now()->addDay();
            $user_task->save();
            $this->emit('user_task_counter_change', 'planned');
        }
        $this->current_task = $user_task;
    }

    public function updatedDueDatePicker($value)
    {
        $this->set_due_date($this->current_task->id, $value);
    }

    public function toggle_reminder_at($task_id)
    {
        if ($this->reminder_at_opened == $task_id) {
            $this->reminder_at_opened = null;
        } else {
            $this->reminder_at_opened = $task_id;
        }
    }

    public function set_reminder_at($task_id, $reminder_date = null)
    {
        $user_task = \App\Models\Task::where('user_id', Auth::id())->where('id', $task_id)->first();
        $reminder_at = null;
        if ($reminder_date === 'custom') {
            $reminder_at = Carbon::create($this->reminder_at_date)
                ->setHour($this->reminder_at_hour)
                ->setMinute(0)
                ->setSecond(0);
        } elseif (!is_null($reminder_date)) {
            $reminder_at = Carbon::create($reminder_date)
                ->setHour(now()->hour)
                ->setMinute(0)
                ->setSecond(0);
        }
        if ($user_task) {
            $user_task->update(['reminder_at' => $reminder_at]);

        } else {
            $task = \App\Models\Task::find($task_id);
            $user_task = $task->replicate();
            $user_task->user_id = Auth::id();
            $user_task->task_id = $task->id;
            $user_task->reminder_at = $reminder_at;
            $user_task->save();
        }
        $this->current_task = $user_task;
    }


}
