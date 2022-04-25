<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;

class DocumentTypeController extends Controller
{
    public function index()
    {
       $document_types = DocumentType::all();
       return response()->json([
           'res' =>true,
           'message' => 'ok',
           'data' => $document_types
       ],200);
    }
}
