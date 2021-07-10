<?php


namespace App\Actions;


use App\DTO\TaskDTO;
use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;

class TaskAction
{
    public function createTask(Checklist $checklist, TaskDTO $DTO): Model
    {
        return $checklist->tasks()->create($DTO->toArray());
    }

    public function updateTask(Task $task, TaskDTO $DTO): bool
    {

        $data = $DTO->toArray();
        unset($data['order']);

        $tasks = Task::query()
            ->where('id', $task->id)
            ->orWhere('task_id', $task->id);

        return $tasks->update($data);
    }
}
