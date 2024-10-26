<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaintenanceStoreRequest;
use App\Http\Requests\MaintenanceUpdateRequest;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $maintenances = Maintenance::all();

        return view('maintenance.index', compact('maintenances'));
    }

    public function create(Request $request)
    {
        return view('maintenance.create');
    }

    public function store(MaintenanceStoreRequest $request)
    {
        $maintenance = Maintenance::create($request->validated());


        return redirect()->route('maintenances.index');
    }

    public function show(Request $request, Maintenance $maintenance)
    {
        return view('maintenance.show', compact('maintenance'));
    }

    public function edit(Request $request, Maintenance $maintenance)
    {
        return view('maintenance.edit', compact('maintenance'));
    }

    public function update(MaintenanceUpdateRequest $request, Maintenance $maintenance)
    {
        $maintenance->update($request->validated());


        return redirect()->route('maintenances.index');
    }

    public function destroy(Request $request, Maintenance $maintenance)
    {
        $maintenance->delete();

        return redirect()->route('maintenances.index');
    }
}
