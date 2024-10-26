<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationStoreRequest;
use App\Http\Requests\NotificationUpdateRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::all();

        return view('notification.index', compact('notifications'));
    }

    public function create(Request $request)
    {
        return view('notification.create');
    }

    public function store(NotificationStoreRequest $request)
    {
        $notification = Notification::create($request->validated());


        return redirect()->route('notifications.index');
    }

    public function show(Request $request, Notification $notification)
    {
        return view('notification.show', compact('notification'));
    }

    public function edit(Request $request, Notification $notification)
    {
        return view('notification.edit', compact('notification'));
    }

    public function update(NotificationUpdateRequest $request, Notification $notification)
    {
        $notification->update($request->validated());


        return redirect()->route('notifications.index');
    }

    public function destroy(Request $request, Notification $notification)
    {
        $notification->delete();

        return redirect()->route('notifications.index');
    }
}
