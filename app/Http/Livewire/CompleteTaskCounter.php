<?php

namespace App\Http\Livewire;

use App\Models\Checklist;
use Livewire\Component;

class CompleteTaskCounter extends Component
{
    public $task_count;
    public $completed_task_count;
    public $checklist_id;

    protected $listeners = ['complete_task' => 'recalculate_tasks'];

    public function render()
    {
        return view('livewire.complete-task-counter');
    }

    public function recalculate_tasks($checklistId)
    {
        $checklist = Checklist::find($checklistId);
        $completed_count = $checklist->user_tasks()->whereNotNull('completed_at')->count();
        if ($this->checklist_id === $checklist->id) {
            $this->completed_task_count = $completed_count;
        }
    }

}
