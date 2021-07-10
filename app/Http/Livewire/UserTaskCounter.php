<?php

namespace App\Http\Livewire;

use App\Models\Checklist;
use Livewire\Component;

class UserTaskCounter extends Component
{
    public $task_count;
    public $task_type;

    protected $listeners = ['user_task_counter_change' => 'recalculate_tasks'];

    public function render()
    {
        return view('livewire.user-task-counter');
    }

    public function recalculate_tasks($type, $change = 1)
    {
        if ($this->task_type == $type) {
            $this->task_count += $change;
        }
    }
}
