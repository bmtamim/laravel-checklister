<?php

namespace App\Http\Controllers\Admin;

use App\Actions\TaskAction;
use App\DTO\TaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    public function index()
    {
        abort(404);
    }


    public function create()
    {
        abort(404);
    }


    public function store(Checklist $checklist, StoreTaskRequest $request, TaskAction $taskAction): RedirectResponse
    {
        $taskAction->createTask($checklist, TaskDTO::createFromRequest($request));

        return redirect()->route('admin.checklist_groups.checklists.edit', [
            $checklist->checklist_groups_id, $checklist
        ]);
    }


    public function show(Task $task)
    {
        abort(404);
    }


    public function edit(Checklist $checklist, Task $task): View
    {
        return view('admin.checklist.task.edit', compact('checklist', 'task'));
    }


    public function update(StoreTaskRequest $request, Checklist $checklist, Task $task, TaskAction $taskAction): RedirectResponse
    {

        $taskAction->updateTask($task, TaskDTO::createFromRequest($request));

        return redirect()->route('admin.checklist_groups.checklists.edit', [
            $checklist->checklist_groups_id, $checklist
        ]);
    }


    public function destroy(Checklist $checklist, Task $task): RedirectResponse
    {
        Task::where('task_id', $task->id)->delete();
        $checklist->tasks()->where('order', '>', $task->order)->decrement('order', 1);

        $task->delete();

        return redirect()->route('admin.checklist_groups.checklists.edit', [
            $checklist->checklist_groups_id, $checklist
        ]);
    }
}
