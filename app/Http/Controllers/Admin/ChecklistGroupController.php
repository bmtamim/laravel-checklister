<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ChecklistGroupAction;
use App\DTO\ChecklistGroupDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChecklistGroupRequest;
use App\Models\ChecklistGroup;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChecklistGroupController extends Controller
{

    public function index()
    {
        abort(404);
    }


    public function create(): View
    {
        return view('admin.checklist_groups.create');
    }


    public function store(StoreChecklistGroupRequest $request, ChecklistGroupAction $checklistGroupAction)
    {
        $checklistGroup = $checklistGroupAction->createChecklistGroup(ChecklistGroupDTO::createFromRequest($request));

        Toastr::success('Checklist Group Created!!', 'Hooray', ['options']);

        if (!$checklistGroup) {
            Toastr::error('Checklist Group Failed To Created!!', 'Oops', ['options']);
        }

        return redirect()->route('admin.dashboard');
    }


    public function show($id)
    {
        abort(404);
    }


    public function edit(ChecklistGroup $checklistGroup): View
    {
        return view('admin.checklist_groups.edit', compact('checklistGroup'));
    }


    public function update(StoreChecklistGroupRequest $request, ChecklistGroup $checklistGroup, ChecklistGroupAction $checklistGroupAction): RedirectResponse
    {
        $checklistGroupAction->updateChecklistGroup($checklistGroup, ChecklistGroupDTO::createFromRequest($request));

        return redirect()->route('admin.dashboard');
    }


    public function destroy(ChecklistGroup $checklistGroup): RedirectResponse
    {
        $checklistGroup->delete();
        return redirect()->route('admin.dashboard');
    }
}
