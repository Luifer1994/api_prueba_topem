<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request["limit"] ? $limit = $request["limit"] : $limit = 5;
        $products = Product::where('name', 'like', '%' . $request["search"] . '%')->paginate($limit);
        return response()->json([
            'res' => true,
            'message' => 'ok',
            'data' => $products,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json([
                'res' => true,
                'message' => 'ok',
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'No se encontro el registro',
                'data' => []
            ], 400);
        }
    }
}
