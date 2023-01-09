<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = auth()->user()->account->documents;
        return view('pages.document',[
            'documents' => $documents
        ]);

    }
}
