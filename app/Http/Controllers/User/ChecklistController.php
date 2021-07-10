<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Services\UserChecklistService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    //Show User Checklist
    public function show(Checklist $checklist): View
    {
        (new UserChecklistService())->sync_checklist($checklist, Auth::id());

        return view('user.checklist.show', compact('checklist'));
    }

    public function taskList($list_type)
    {
        return view('user.checklist.tasklist', compact('list_type'));
    }
}
