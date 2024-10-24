<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyAmenityControllerStoreRequest;
use App\Http\Requests\PropertyAmenityControllerUpdateRequest;
use App\Models\PropertyAmenity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyAmenityController extends Controller
{
    public function index(Request $request): Response
    {
        $propertyAmenities = PropertyAmenity::all();

        return view('propertyAmenity.index', compact('propertyAmenities'));
    }

    public function create(Request $request): Response
    {
        return view('propertyAmenity.create');
    }

    public function store(PropertyAmenityControllerStoreRequest $request): Response
    {
        $propertyAmenity = PropertyAmenity::create($request->validated());

        $request->session()->flash('propertyAmenity.id', $propertyAmenity->id);

        return redirect()->route('propertyAmenities.index');
    }

    public function show(Request $request, PropertyAmenity $propertyAmenity): Response
    {
        return view('propertyAmenity.show', compact('propertyAmenity'));
    }

    public function edit(Request $request, PropertyAmenity $propertyAmenity): Response
    {
        return view('propertyAmenity.edit', compact('propertyAmenity'));
    }

    public function update(PropertyAmenityControllerUpdateRequest $request, PropertyAmenity $propertyAmenity): Response
    {
        $propertyAmenity->update($request->validated());

        $request->session()->flash('propertyAmenity.id', $propertyAmenity->id);

        return redirect()->route('propertyAmenities.index');
    }

    public function destroy(Request $request, PropertyAmenity $propertyAmenity): Response
    {
        $propertyAmenity->delete();

        return redirect()->route('propertyAmenities.index');
    }
}
