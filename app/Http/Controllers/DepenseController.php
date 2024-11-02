<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepenseController extends Controller
{
    public function index()
    {
        $depenses = Depense::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $totalDepenses = Depense::where('user_id', Auth::id())->sum('montant');
        $nombreDepenses = Depense::where('user_id', Auth::id())->count();

        return view('depense.index', compact('depenses', 'totalDepenses', 'nombreDepenses'));
    }

    public function create()
    {
        $categories = ['Loyer', 'Nourriture', 'Transport', 'Loisirs', 'Santé', 'Autres'];
        $modes_paiement = ['Espèces', 'Carte bancaire', 'Virement', 'Chèque', 'Mobile Money'];

        return view('depense.create', compact('categories', 'modes_paiement'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'montant' => 'required|numeric|min:0',
            'date_depense' => 'required|date',
            'categorie' => 'required|string',
            'mode_paiement' => 'required|string',
            'reference' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        Depense::create($validated);

        return redirect()->route('depenses.index')
            ->with('success', 'Dépense enregistrée avec succès.');
    }

    public function show(Depense $depense)
    {
        if ($depense->user_id !== Auth::id()) {
            abort(403);
        }

        return view('depense.show', compact('depense'));
    }

    public function edit(Depense $depense)
    {
        if ($depense->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = ['Loyer', 'Nourriture', 'Transport', 'Loisirs', 'Santé', 'Autres'];
        $modes_paiement = ['Espèces', 'Carte bancaire', 'Virement', 'Chèque', 'Mobile Money'];

        return view('depense.edit', compact('depense', 'categories', 'modes_paiement'));
    }

    public function update(Request $request, Depense $depense)
    {
        if ($depense->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'montant' => 'required|numeric|min:0',
            'date_depense' => 'required|date',
            'categorie' => 'required|string',
            'mode_paiement' => 'required|string',
            'reference' => 'nullable|string|max:255',
        ]);

        $depense->update($validated);

        return redirect()->route('depenses.index')
            ->with('success', 'Dépense mise à jour avec succès.');
    }

    public function destroy(Depense $depense)
    {
        if ($depense->user_id !== Auth::id()) {
            abort(403);
        }

        $depense->delete();

        return redirect()->route('depenses.index')
            ->with('success', 'Dépense supprimée avec succès.');
    }
}
