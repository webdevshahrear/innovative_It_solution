<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkFlow;
use Illuminate\Http\Request;

class WorkFlowController extends Controller
{
    public function index()
    {
        $workFlows = WorkFlow::ordered()->get();
        return view('admin.work-flows.index', compact('workFlows'));
    }

    public function create()
    {
        return view('admin.work-flows.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'icon_class' => 'required',
            'display_order' => 'required|integer',
        ]);

        WorkFlow::create($request->all());

        return redirect()->route('admin.work-flows.index')->with('success', 'Work Flow step created successfully.');
    }

    public function edit(WorkFlow $workFlow)
    {
        return view('admin.work-flows.edit', compact('workFlow'));
    }

    public function update(Request $request, WorkFlow $workFlow)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'icon_class' => 'required',
            'display_order' => 'required|integer',
        ]);

        $workFlow->update($request->all());

        return redirect()->route('admin.work-flows.index')->with('success', 'Work Flow step updated successfully.');
    }

    public function destroy(WorkFlow $workFlow)
    {
        $workFlow->delete();
        return redirect()->route('admin.work-flows.index')->with('success', 'Work Flow step deleted successfully.');
    }

    public function duplicate(WorkFlow $workFlow)
    {
        $newWorkFlow = $workFlow->replicate();
        $newWorkFlow->title = $newWorkFlow->title . ' (Copy)';
        $newWorkFlow->display_order = WorkFlow::max('display_order') + 1;
        $newWorkFlow->save();

        return redirect()->route('admin.work-flows.index')->with('success', 'Work Flow step duplicated successfully.');
    }
}
