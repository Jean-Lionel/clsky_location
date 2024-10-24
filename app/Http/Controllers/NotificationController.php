<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationControllerStoreRequest;
use App\Http\Requests\NotificationControllerUpdateRequest;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): Response
    {
        $notifications = Notification::all();

        return view('notification.index', compact('notifications'));
    }

    public function create(Request $request): Response
    {
        return view('notification.create');
    }

    public function store(NotificationControllerStoreRequest $request): Response
    {
        $notification = Notification::create($request->validated());

        $request->session()->flash('notification.id', $notification->id);

        return redirect()->route('notifications.index');
    }

    public function show(Request $request, Notification $notification): Response
    {
        return view('notification.show', compact('notification'));
    }

    public function edit(Request $request, Notification $notification): Response
    {
        return view('notification.edit', compact('notification'));
    }

    public function update(NotificationControllerUpdateRequest $request, Notification $notification): Response
    {
        $notification->update($request->validated());

        $request->session()->flash('notification.id', $notification->id);

        return redirect()->route('notifications.index');
    }

    public function destroy(Request $request, Notification $notification): Response
    {
        $notification->delete();

        return redirect()->route('notifications.index');
    }
}
