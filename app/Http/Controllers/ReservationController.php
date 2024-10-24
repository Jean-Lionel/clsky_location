<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationControllerStoreRequest;
use App\Http\Requests\ReservationControllerUpdateRequest;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(Request $request): Response
    {
        $reservations = Reservation::all();

        return view('reservation.index', compact('reservations'));
    }

    public function create(Request $request): Response
    {
        return view('reservation.create');
    }

    public function store(ReservationControllerStoreRequest $request): Response
    {
        $reservation = Reservation::create($request->validated());

        $request->session()->flash('reservation.id', $reservation->id);

        return redirect()->route('reservations.index');
    }

    public function show(Request $request, Reservation $reservation): Response
    {
        return view('reservation.show', compact('reservation'));
    }

    public function edit(Request $request, Reservation $reservation): Response
    {
        return view('reservation.edit', compact('reservation'));
    }

    public function update(ReservationControllerUpdateRequest $request, Reservation $reservation): Response
    {
        $reservation->update($request->validated());

        $request->session()->flash('reservation.id', $reservation->id);

        return redirect()->route('reservations.index');
    }

    public function destroy(Request $request, Reservation $reservation): Response
    {
        $reservation->delete();

        return redirect()->route('reservations.index');
    }
}
