<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentStoreRequest;
use App\Http\Requests\DocumentUpdateRequest;
use App\Models\Document;
use Illuminate\Http\Request;
class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = Document::all();

        return view('document.index', compact('documents'));
    }

    public function create(Request $request)
    {
        return view('document.create');
    }

    public function store(DocumentStoreRequest $request)
    {
        $document = Document::create($request->validated());


        return redirect()->route('documents.index');
    }

    public function show(Request $request, Document $document)
    {
        return view('document.show', compact('document'));
    }

    public function edit(Request $request, Document $document)
    {
        return view('document.edit', compact('document'));
    }

    public function update(DocumentUpdateRequest $request, Document $document)
    {
        $document->update($request->validated());

        return redirect()->route('documents.index');
    }

    public function destroy(Request $request, Document $document)
    {
        $document->delete();

        return redirect()->route('documents.index');
    }
}
