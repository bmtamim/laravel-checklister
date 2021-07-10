<?php


namespace App\Actions;


use App\DTO\ChecklistDTO;
use App\Models\Checklist;
use App\Models\ChecklistGroup;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;

class ChecklistAction
{

    public function createChecklist(ChecklistGroup $checklistGroup, ChecklistDTO $DTO): Model
    {
        return $checklistGroup->checklists()->create($DTO->toArray());
    }

    public function updateChecklist(Checklist $checklist, ChecklistDTO $DTO)
    {
        $checklists = Checklist::query()
            ->where('id', $checklist->id)
            ->orWhere('checklist_id', $checklist->id);

        $checklists->update($DTO->toArray());
    }
}
