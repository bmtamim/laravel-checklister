<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ChecklistAction;
use App\DTO\ChecklistDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChecklistRequest;
use App\Models\Checklist;
use App\Models\ChecklistGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{

    public function index()
    {
        abort(404);
    }


    public function create(ChecklistGroup $checklistGroup): View
    {
        return view('admin.checklist.create', compact('checklistGroup'));
    }


    public function store(StoreChecklistRequest $request, ChecklistGroup $checklistGroup, ChecklistAction $checklistAction): RedirectResponse
    {
        $checklistAction->createChecklist($checklistGroup, ChecklistDTO::createFromRequest($request));

        return redirect()->route('admin.dashboard');
    }


    public function show(Checklist $checklist): void
    {
        abort(404);
    }


    public function edit(ChecklistGroup $checklistGroup, Checklist $checklist): View
    {
        return view('admin.checklist.edit', compact('checklistGroup', 'checklist'));
    }


    public function update(StoreChecklistRequest $request, ChecklistGroup $checklistGroup, Checklist $checklist, ChecklistAction $checklistAction): RedirectResponse
    {
        $checklistAction->updateChecklist($checklist, ChecklistDTO::createFromRequest($request));

        return redirect()->route('admin.dashboard');
    }


    public function destroy(ChecklistGroup $checklistGroup, Checklist $checklist): RedirectResponse
    {
        $checklist->delete();

        return redirect()->route('admin.dashboard');
    }
}
