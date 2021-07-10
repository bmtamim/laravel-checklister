<?php


namespace App\Actions;


use App\DTO\ChecklistGroupDTO;
use App\Models\ChecklistGroup;
use Carbon\Carbon;

class ChecklistGroupAction
{
    public function createChecklistGroup(ChecklistGroupDTO $DTO)
    {

        return ChecklistGroup::create($DTO->toArray());

    }

    public function updateChecklistGroup(ChecklistGroup $checklistGroup, ChecklistGroupDTO $DTO): bool
    {
        return $checklistGroup->update($DTO->toArray());
    }
}
