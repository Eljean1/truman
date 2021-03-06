<?php

namespace App\Http\Controllers;

use App\Author;
use App\Editorial;
use App\Inventory;
use App\Product;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $inventarios = Inventory::where('id_producto', 4)
        //     ->orderBy('id_bodega')
        //     ->get();
        // $auxCantidadLibros = 5;
        // foreach ($inventarios as $value) {
        //     if ($auxCantidadLibros != 0) {
        //         if ($auxCantidadLibros >= $value->stock_actual) {
        //             $auxCantidadLibros -= $value->stock_actual;


        //             $value->stock_actual = 0;
        //             $value->save();
        //         } else {

        //             $value->stock_actual = $value->stock_actual - $auxCantidadLibros;
        //             $value->save();
        //             $auxCantidadLibros = 0;
        //         }
        //     }
        // }

        // return $auxCantidadLibros;

        return Product::with([
            'author',
            'editorial',
            'subfamily',
            'topic',
            'unit',
            'subfamily.family',
            'cellars',
        ])
        ->select(DB::raw('producto.*, sum(inventario.stock_actual) as stock_actual'))
        ->join('inventario', 'producto.id_producto', '=', 'inventario.id_producto')
        ->join('bodega', function ($join) {
            $join->on('inventario.id_bodega', '=', 'bodega.id_bodega')
                ->select('bodega.descripcion as hola')
                ->where('bodega.id_sucursal', auth()->user()->id_sucursal)
                ->whereIn('bodega.operaciones', [1, 2]);
        })
        ->groupBy('producto.id_producto')
        ->orderBy('stock_actual', 'desc')
        ->get();
    }

    public function autores()
    {
        return Author::all();
    }

    public function editoriales()
    {
        return Editorial::all();
    }

    public function temas()
    {
        return Topic::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
