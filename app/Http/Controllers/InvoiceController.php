<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $new_start_date = $request["start_date"];
        $new_end_date   = $request["finish_date"];
        $limit = $request["limit"] ?? $limit = 10;
        $order = $request["order"] ?? "DESC";
        $invoices = Invoice::select(
            'invoices.*',
            'clients.name as name_client',
            'clients.last_name as last_name_client',
        )->join('clients', 'clients.id', '=', 'invoices.client_id')
            ->where('invoices.id', 'like', '%' . $request["search"] . '%')
            //->orwhere('clients.name', 'like', '%' . $request["search"] . '%')
            ->where(function ($query) use ($new_start_date, $new_end_date) {
                if ($new_start_date && $new_end_date) {
                    $query->whereBetween('invoices.created_at', [$new_start_date, $new_end_date]);
                }
            })
            ->orderBy('invoices.id', $order)
            ->paginate($limit);
        return response()->json([
            "res"   => true,
            "data"  => $invoices
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateInvoiceRequest $request)
    {
        $iva = 0;
        $sub_total = 0;
        foreach ($request["products"] as $value) {
            $product = Product::find($value["id"]);
            if ($product->iva) {
                $iva += ($product->price * 0.19) * $value["quantity"];
            }
            $sub_total += $product->price * $value["quantity"];
        }
        $total = $sub_total + $iva;
        if (
            (string)$request["total_iva"]       === (string)$iva
            || (string)$request["sub_total"]    === (string)$sub_total
            || (string)$request["total"]        === (string)$total
        ) {
            $new_invoice = new Invoice();
            $new_invoice->client_id         = $request["client_id"];
            $new_invoice->user_creator_id   = Auth::user()->id;
            $new_invoice->total_iva         = $iva;
            $new_invoice->sub_total         = $sub_total;
            $new_invoice->total             = $total;
            $new_invoice->user_update_id    = $new_invoice->user_creator_id;

            if ($new_invoice->save()) {
                foreach ($request["products"]  as  $value) {
                    $new_invoice_line = new InvoiceLine();
                    $new_invoice_line->product_id   = $value["id"];
                    $new_invoice_line->invoice_id   = $new_invoice->id;
                    $new_invoice_line->quantity     = $value["quantity"];
                    if (!$new_invoice_line->save()) {
                        return response()->json([
                            'res'       => false,
                            'message'   => 'Error al registrar el detalle de la factura con producto ' . $value["id"],
                        ], 400);
                    }
                }
                return response()->json([
                    'res'       => true,
                    'message'   => 'Registro exitoso',
                    'data'      => ['invoice' => $new_invoice]
                ], 200);
            } else {
                return response()->json([
                    'res'       => false,
                    'message'   => 'Error al facturar',
                ], 400);
            }
        } else {
            return response()->json([
                'res'       => false,
                'message'   => 'Error al facturar valores incorrectos',
                'expected_values'      => ['total' => $total, 'iva' => $iva, 'sub_total' => $sub_total]
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::select(
            'invoices.*',
            'clients.name as client_name',
            'clients.last_name as last_name_client',
            'clients.document_number as document_number_client',
            'document_types.name as document_type',
            'users.name as official',
            'companies.name as name_company',
            'companies.nit as nit_company',
        )
            ->join('clients', 'clients.id', '=', 'invoices.client_id')
            ->join('document_types', 'document_types.id', '=', 'clients.document_type_id')
            ->join('users', 'users.id', '=', 'invoices.user_creator_id')
            ->join('companies', 'companies.id', '=', 'users.company_id')
            ->where('invoices.id', $id)
            ->with('invoice_lines')
            ->first();

        if ($invoice) {
            return response()->json([
                'res'       => true,
                'message'   => 'ok',
                'data'      => $invoice
            ], 200);
        } else {
            return response()->json([
                'res'       => false,
                'message'   => 'No se encontro el registro',
                'data'      => []
            ], 400);
        }
    }
}
