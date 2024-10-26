<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageControllerStoreRequest;
use App\Http\Requests\MessageControllerUpdateRequest;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Requests\MessageUpdateRequest;
use App\Models\Message;
use Illuminate\Http\Request;
class MessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = Message::all();

        return view('message.index', compact('messages'));
    }

    public function create(Request $request)
    {
        return view('message.create');
    }

    public function store(MessageStoreRequest $request)
    {
        $message = Message::create($request->validated());


        return redirect()->route('messages.index');
    }

    public function show(Request $request, Message $message)
    {
        return view('message.show', compact('message'));
    }

    public function edit(Request $request, Message $message)
    {
        return view('message.edit', compact('message'));
    }

    public function update(MessageUpdateRequest $request, Message $message)
    {
        $message->update($request->validated());


        return redirect()->route('messages.index');
    }

    public function destroy(Request $request, Message $message)
    {
        $message->delete();

        return redirect()->route('messages.index');
    }
}
