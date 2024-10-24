<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageControllerStoreRequest;
use App\Http\Requests\MessageControllerUpdateRequest;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): Response
    {
        $messages = Message::all();

        return view('message.index', compact('messages'));
    }

    public function create(Request $request): Response
    {
        return view('message.create');
    }

    public function store(MessageControllerStoreRequest $request): Response
    {
        $message = Message::create($request->validated());

        $request->session()->flash('message.id', $message->id);

        return redirect()->route('messages.index');
    }

    public function show(Request $request, Message $message): Response
    {
        return view('message.show', compact('message'));
    }

    public function edit(Request $request, Message $message): Response
    {
        return view('message.edit', compact('message'));
    }

    public function update(MessageControllerUpdateRequest $request, Message $message): Response
    {
        $message->update($request->validated());

        $request->session()->flash('message.id', $message->id);

        return redirect()->route('messages.index');
    }

    public function destroy(Request $request, Message $message): Response
    {
        $message->delete();

        return redirect()->route('messages.index');
    }
}
