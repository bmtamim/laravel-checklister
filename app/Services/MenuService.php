<?php


namespace App\Services;


use App\Models\Checklist;
use App\Models\ChecklistGroup;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MenuService
{
    public function get_menu()
    {
        $checklistGroups = ChecklistGroup::with(['checklists' => function ($query) {
            $query->whereNull(['user_id', 'checklist_id']);
        }, 'checklists.tasks'                                 => function ($query) {
            $query->whereNull('tasks.user_id');
        }])->get();

        if (is_null(auth()->user()->save_last_action)) {
            auth()->user()->update([
                'save_last_action' => Carbon::now()->subYears(5),
            ]);
        }

        $userChecklists = Checklist::where(['user_id' => auth()->id()])->get();

        $groups = [];
        foreach ($checklistGroups as $checklistGroup) {
            if ($checklistGroup->checklists()->count() > 0) {
                $group_updated_at = $userChecklists->where('checklist_groups_id', $checklistGroup['id'])->max('updated_at');

                $checklistGroup['is_new'] = $group_updated_at && Carbon::parse($checklistGroup['created_at'])->greaterThan($group_updated_at);

                $checklistGroup['is_updated'] = !($checklistGroup['is_new']) && $group_updated_at && Carbon::parse($checklistGroup['updated_at'])->greaterThan($group_updated_at);

                foreach ($checklistGroup->checklists as &$checklist) {
                    $checklist_updated_at = $userChecklists->where('checklist_id', $checklist->id)->max('updated_at');

                    $checklist['is_new'] = !($checklistGroup['is_new']) && !($checklistGroup['is_updated']) && !($checklist['is_new']) && Carbon::parse($checklist['created_at'])->greaterThan($checklist_updated_at);

                    $checklist['is_updated'] = !($checklistGroup['is_new']) && !($checklistGroup['is_updated']) && !($checklist['is_new']) && Carbon::parse($checklist['updated_at'])->greaterThan($checklist_updated_at);

                    $checklist['tasks_count'] = $checklist->tasks()->whereNull('user_id')->whereNull('task_id')->count();
                    $checklist['completed_tasks_count'] = $checklist->user_tasks()->whereNotNull('completed_at')->count();
                }
                $groups[] = $checklistGroup;
            }
        }

        $user_tasks_menu = [];
        if (!Auth::user()->is_admin) {
            $userTask = Task::where('user_id', Auth::id())->get();
            $user_tasks_menu = [
                'my_day'    => [
                    'name'        => __('My Day'),
                    'icon'        => 'sun',
                    'tasks_count' => $userTask->whereNotNull('add_to_my_day')->count(),
                ],
                'important' => [
                    'name'        => __('Important'),
                    'icon'        => 'star',
                    'tasks_count' => $userTask->where('is_important', true)->count(),
                ],
                'planned'   => [
                    'name'        => __('Planned'),
                    'icon'        => 'calendar',
                    'tasks_count' => $userTask->whereNotNull('due_date')->count()
                ],
            ];
        }

        return [
            'admin'           => $checklistGroups,
            'user'            => $groups,
            'user_tasks_menu' => $user_tasks_menu,
        ];
    }
}
