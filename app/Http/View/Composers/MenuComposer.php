<?php

namespace App\Http\View\Composers;

use App\Models\Checklist;
use App\Models\ChecklistGroup;
use App\Services\MenuService;
use Carbon\Carbon;
use Illuminate\View\View;

class MenuComposer
{

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $getMenu = (new MenuService())->get_menu();
        $view->with('admin_menu', $getMenu['admin']);
        $view->with('user_menu', $getMenu['user']);
        $view->with('user_tasks_menu', $getMenu['user_tasks_menu']);
    }
}
