<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $statistics = Statistic::all();
        return view('admin.statistics.index', compact('statistics'));
    }

    public function create()
    {
        return view('admin.statistics.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'stat_label' => 'required',
            'stat_value' => 'required',
            'icon_class' => 'required',
            'stat_key' => 'required|unique:statistics',
            'status' => 'required|in:active,inactive'
        ]);

        Statistic::create($request->all() + ['display_order' => Statistic::max('display_order') + 1]);

        return redirect()->route('admin.statistics.index')->with('success', 'Statistic created successfully.');
    }

    public function edit(Statistic $statistic)
    {
        return view('admin.statistics.edit', compact('statistic'));
    }

    public function update(Request $request, Statistic $statistic)
    {
        $request->validate([
            'stat_label' => 'required',
            'stat_value' => 'required',
            'icon_class' => 'required',
            'status' => 'required|in:active,inactive'
        ]);

        $statistic->update($request->all());

        return redirect()->route('admin.statistics.index')->with('success', 'Statistic updated successfully.');
    }

    public function destroy(Statistic $statistic)
    {
        $statistic->delete();
        return redirect()->route('admin.statistics.index')->with('success', 'Statistic deleted successfully.');
    }
}
