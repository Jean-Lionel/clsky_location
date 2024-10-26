<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserControllerStoreRequest;
use App\Http\Requests\UserControllerUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::latest()->paginate();

        return view('user.index', compact('users'));
    }

    public function create(Request $request)
    {
        return view('user.create');
    }

    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->validated());

        $request->session()->flash('user.id', $user->id);

        return redirect()->route('users.index');
    }

    public function show(Request $request, User $user)
    {
        return view('user.show', compact('user'));
    }

    public function edit(Request $request, User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update( $request, User $user)
    {
        $user->update($request->validated());

        $request->session()->flash('user.id', $user->id);

        return redirect()->route('users.index');
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
