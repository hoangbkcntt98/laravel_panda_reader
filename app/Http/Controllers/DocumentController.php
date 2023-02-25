<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Material;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = auth()->user()->account->documents;
        return view('pages.document.index', [
            'documents' => $documents
        ]);
    }


    public function store(Request $request)
    {
        $ownerId = auth()->user()->account->id;
        $topic = $request->get('topic');
        $image = $request->get('image') ?? '';
    
        $document = Document::create([
            'owner_id' => $ownerId,
            'topic' => $topic,
            'image' => $image   
        ]);
        return redirect(route('documents.index'));
    }

    public function delete(Request $request, $id)
    {
        Document::where('id', $id)->delete();
        Material::where('document_id', $id)->delete();
        return redirect(route('documents.index'));
    }

    public function edit(Request $request, $id)
    {
        $doc = Document::where('id', $id)->first();
        $doc->topic = $request->get('topic');
        $doc->image = $request->get('image');
        $doc->save();
        return redirect(route('documents.index'));

    }
}
