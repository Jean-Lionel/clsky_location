<?php

namespace App\Http\Controllers;
use App\Http\Requests\AmenityStoreRequest;
use App\Http\Requests\AmenityUpdateRequest;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function index(Request $request)
    {
        $amenities = Amenity::all();

        return view('amenity.index', compact('amenities'));
    }

    public function create(Request $request)
    {
        return view('amenity.create');
    }

    public function store(AmenityStoreRequest $request)
    {
        $amenity = Amenity::create($request->validated());


        return redirect()->route('amenities.index');
    }

    public function show(Request $request, Amenity $amenity)
    {
        return view('amenity.show', compact('amenity'));
    }

    public function edit(Request $request, Amenity $amenity)
    {
        return view('amenity.edit', compact('amenity'));
    }

    public function update(AmenityUpdateRequest $request, Amenity $amenity)
    {
        $amenity->update($request->validated());


        return redirect()->route('amenities.index');
    }

    public function destroy(Request $request, Amenity $amenity)
    {
        $amenity->delete();

        return redirect()->route('amenities.index');
    }
}
