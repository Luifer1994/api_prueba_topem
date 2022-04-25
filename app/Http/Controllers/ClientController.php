<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request["limit"] ?? $limit = 10;
        $clients = Client::select(
            'clients.*',
            'document_types.name as document_type'
        )
            ->join('document_types', 'document_types.id', '=', 'clients.document_type_id')
            ->withCount('invoices')
            ->orderBy('clients.id', 'DESC')
            ->paginate($limit);

        return response()->json([
            'res' => true,
            'message' => 'ok',
            'data' => $clients
        ], 200);
    }

    public function getByDocumentTypeAndNumber(Request $request)
    {

        $client =  DB::table('clients')
            ->where('document_type_id', '=', $request["document_type_id"])
            ->where('document_number', '=', $request["document_number"])->first();
        return response()->json([
            'res' => true,
            'message' => 'ok',
            'data' => $client
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClientRequest $request)
    {
        $new_client = Client::create($request->all());

        if ($new_client) {
            return response()->json([
                'res' => true,
                'message' => 'ok',
                'data' => $new_client
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'error al registrar',
                'data' => []
            ], 400);
        }
    }

}
