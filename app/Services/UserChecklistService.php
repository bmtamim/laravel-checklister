<?php


namespace App\Services;


use App\Models\Checklist;

class UserChecklistService
{
    public function sync_checklist(Checklist $checklist, int $userId): Checklist
    {
        $checklist = Checklist::firstOrCreate([
            'user_id'      => $userId,
            'checklist_id' => $checklist->id,
        ],
            [
                'checklist_groups_id' => $checklist->checklist_groups_id,
                'name'                => $checklist->name,
            ]);

        $checklist->touch();

        return $checklist;
    }
}
