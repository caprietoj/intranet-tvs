<?php
namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $requests = DocumentRequest::with(['user', 'document'])->latest()->paginate(10);
        return view('document-requests.index', compact('requests'));
    }

    public function create()
    {
        $documents = Document::all();
        return view('document-requests.create', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'description' => 'required|string'
        ]);

        $request->merge(['user_id' => auth()->id()]);
        DocumentRequest::create($request->all());
        return redirect()->route('document-requests.index')->with('success', 'Solicitud creada exitosamente');
    }

    public function edit(DocumentRequest $documentRequest)
    {
        $documents = Document::all();
        return view('document-requests.edit', compact('documentRequest', 'documents'));
    }

    public function update(Request $request, DocumentRequest $documentRequest)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'description' => 'required|string',
            'status' => 'required|in:abierto,en proceso,cerrado'
        ]);

        $documentRequest->update($request->all());
        return redirect()->route('document-requests.index')->with('success', 'Solicitud actualizada exitosamente');
    }
}
