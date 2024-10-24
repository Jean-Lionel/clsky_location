<?php

namespace App\Http\Controllers;

use App\Http\Requests\AmenityControllerStoreRequest;
use App\Http\Requests\AmenityControllerUpdateRequest;
use App\Models\Amenity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AmenityController extends Controller
{
    public function index(Request $request): Response
    {
        $amenities = Amenity::all();

        return view('amenity.index', compact('amenities'));
    }

    public function create(Request $request): Response
    {
        return view('amenity.create');
    }

    public function store(AmenityControllerStoreRequest $request): Response
    {
        $amenity = Amenity::create($request->validated());

        $request->session()->flash('amenity.id', $amenity->id);

        return redirect()->route('amenities.index');
    }

    public function show(Request $request, Amenity $amenity): Response
    {
        return view('amenity.show', compact('amenity'));
    }

    public function edit(Request $request, Amenity $amenity): Response
    {
        return view('amenity.edit', compact('amenity'));
    }

    public function update(AmenityControllerUpdateRequest $request, Amenity $amenity): Response
    {
        $amenity->update($request->validated());

        $request->session()->flash('amenity.id', $amenity->id);

        return redirect()->route('amenities.index');
    }

    public function destroy(Request $request, Amenity $amenity): Response
    {
        $amenity->delete();

        return redirect()->route('amenities.index');
    }
}
