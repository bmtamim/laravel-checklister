<?php

namespace App\Http\Livewire;

use App\Http\Requests\StoreTaskRequest;
use Livewire\Component;

class AddTask extends Component
{
    public $checklist;
    public $name;
    public $description;

    public function store(StoreTaskRequest $request)
    {
        $this->validate([
            'name' => ['required']
        ]);
    }

    public function render()
    {
        return view('livewire.add-task');
    }
}
