<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaintenanceControllerStoreRequest;
use App\Http\Requests\MaintenanceControllerUpdateRequest;
use App\Models\Maintenance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    public function index(Request $request): Response
    {
        $maintenances = Maintenance::all();

        return view('maintenance.index', compact('maintenances'));
    }

    public function create(Request $request): Response
    {
        return view('maintenance.create');
    }

    public function store(MaintenanceControllerStoreRequest $request): Response
    {
        $maintenance = Maintenance::create($request->validated());

        $request->session()->flash('maintenance.id', $maintenance->id);

        return redirect()->route('maintenances.index');
    }

    public function show(Request $request, Maintenance $maintenance): Response
    {
        return view('maintenance.show', compact('maintenance'));
    }

    public function edit(Request $request, Maintenance $maintenance): Response
    {
        return view('maintenance.edit', compact('maintenance'));
    }

    public function update(MaintenanceControllerUpdateRequest $request, Maintenance $maintenance): Response
    {
        $maintenance->update($request->validated());

        $request->session()->flash('maintenance.id', $maintenance->id);

        return redirect()->route('maintenances.index');
    }

    public function destroy(Request $request, Maintenance $maintenance): Response
    {
        $maintenance->delete();

        return redirect()->route('maintenances.index');
    }
}
