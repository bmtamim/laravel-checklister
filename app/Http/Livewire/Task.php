<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Task extends Component
{
    public $checklist;

    public function render()
    {
        $tasks = $this->checklist->tasks()->whereNull('user_id')->whereNull('task_id')->whereNull('completed_at')->orderBy('order')->get();
        return view('livewire.task', ['tasks' => $tasks]);
    }

    public function taskOrderUp($task_id)
    {
        $task = \App\Models\Task::whereNull('user_id')->whereNull('task_id')->find($task_id);
        if ($task) {
            \App\Models\Task::where('checklist_id', $task->checklist_id)->whereNull('user_id')->whereNull('task_id')->where('order', $task->order - 1)->update([
                'order' => $task->order,
            ]);
            $task->update([
                'order' => $task->order - 1,
            ]);
        }
    }

    public function taskOrderDown($task_id)
    {
        $task = \App\Models\Task::whereNull('user_id')->whereNull('task_id')->find($task_id);
        if ($task) {
            \App\Models\Task::where('checklist_id', $task->checklist_id)->whereNull('user_id')->whereNull('task_id')->where('order', $task->order + 1)->update([
                'order' => $task->order,
            ]);
            $task->update([
                'order' => $task->order + 1,
            ]);
        }
    }
//    public function updateTaskOrder($list)
//    {
//        foreach ($list as $item) {
//            $this->checklist->tasks()->find($item['value'])->update(['order' => $item['order']]);
//        }
//    }
}
