<?php

namespace App\Http\Livewire;

use App\Models\Checklist;
use Livewire\Component;

class HeaderTotalCount extends Component
{
    public $checklist_group_id;

    protected $listeners = ['complete_task' => 'renderAgain'];

    public function render()
    {
        $checklists = Checklist::query()
            ->where('checklist_groups_id', $this->checklist_group_id)
            ->whereNull('user_id')
            ->withCount([
                'tasks'      => function ($query) {
                    $query->whereNull('user_id')->whereNull('task_id');
                },
                'user_tasks' => function ($query) {
                    $query->whereNotNull('completed_at');
                }
            ])
            ->whereNull('checklist_id')
            ->get();
        return view('livewire.header-total-count', compact('checklists'));
    }

    public function renderAgain($checklist)
    {
        $this->render();
    }
}
