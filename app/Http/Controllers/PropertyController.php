<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyControllerStoreRequest;
use App\Http\Requests\PropertyControllerUpdateRequest;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): Response
    {
        $properties = Property::all();

        return view('property.index', compact('properties'));
    }

    public function create(Request $request): Response
    {
        return view('property.create');
    }

    public function store(PropertyControllerStoreRequest $request): Response
    {
        $property = Property::create($request->validated());

        $request->session()->flash('property.id', $property->id);

        return redirect()->route('properties.index');
    }

    public function show(Request $request, Property $property): Response
    {
        return view('property.show', compact('property'));
    }

    public function edit(Request $request, Property $property): Response
    {
        return view('property.edit', compact('property'));
    }

    public function update(PropertyControllerUpdateRequest $request, Property $property): Response
    {
        $property->update($request->validated());

        $request->session()->flash('property.id', $property->id);

        return redirect()->route('properties.index');
    }

    public function destroy(Request $request, Property $property): Response
    {
        $property->delete();

        return redirect()->route('properties.index');
    }
}
