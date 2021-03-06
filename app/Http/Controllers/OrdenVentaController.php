<?php

namespace App\Http\Controllers;

use App\Detalle_forma_pago;
use App\Detalle_orden_venta;
use App\Document;
use App\inter_mov_salida;
use App\Forma_pago;
use App\Inventory;
use App\Orden_venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenVentaController extends Controller
{
    function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Orden_venta::with([
            'detallesOrdenVenta',
            'document'
        ])
        ->orderBy('numero_documento', 'desc')->get();
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
        $ultimoNumero = 0;

        $documento = DB::table('documento')->where('nombre_corto', 'like', $request->input('tipo-documento'))->first();
        $ultimoDocumento = Orden_venta::where('id_documento', $documento->id_documento)->latest('id_orden_venta')->first();

        if ($ultimoDocumento != null) {
            if ($ultimoDocumento->numero_documento != null) {
                $ultimoNumero = $ultimoDocumento->numero_documento + 1;
            }
        }

        $orden_venta = Orden_venta::create([
            'id_cliente_proveedor' => $request->input('cliente-payment'),
            'fecha_documento' => date('YmdHi'),
            'numero_documento' => $ultimoNumero + 1,
            'total_bruto' => round($request->input('total-bruto')),
            'total_neto' => round($request->input('total-neto')),
            'iva' => round($request->input('iva')),
            'total_pagado' => round($request->input('total-pagado')),
            'total_vuelto' => round($request->input('total-vuelto', 0)),
            'id_documento' => $documento->id_documento,
            'id_usuario' => auth()->user()->id
        ]);

        $forma_pagos = $request->input('forma-pago');
        $montos = $request->input('monto');
        $ids_productos = $request->input('id-producto');
        $cantidades = $request->input('cantidad');
        $precios_unitarios = $request->input('precio-unitario');
        $totales_libros = $request->input('total-libro');

        foreach ($forma_pagos as $key => $value) {
            $forma_pago = Forma_pago::where('nombre_corto', 'like', $value)->first();

            $detalle_forma_pago = Detalle_forma_pago::create([
                'monto' => $montos[$key]
            ]);

            $detalle_forma_pago->ordenVenta()->associate($orden_venta);
            $detalle_forma_pago->formaPago()->associate($forma_pago);
            $detalle_forma_pago->save();
        }

        foreach ($ids_productos as $key => $value) {
            $cantidadLibros = $cantidades[$key];

            $detalle_orden_venta = Detalle_orden_venta::create([
                'id_orden_venta' => $orden_venta->id_orden_venta,
                'id_producto' => $value,
                'cantidad' => $cantidadLibros,
                'precio_unitario' => round($precios_unitarios[$key]),
                'total' => round($totales_libros[$key])
                ]);

            $inters = inter_mov_salida::where('id_producto',  $value)
            ->orderBy('id_bodega')
            ->orderBy('fecha_ingreso')
            ->get();

            $auxCantidadLibros = $cantidadLibros;
            foreach ($inters as $inter) {
                if ($auxCantidadLibros != 0) {
                    if ($auxCantidadLibros >= $inter->cantidad) {
                        $auxCantidadLibros -= $inter->cantidad;
                        $inter->cantidad = 0;
                        $inter->save();
                    } else {
                        $inter->cantidad = $value->cantidad - $auxCantidadLibros;
                        $inter->save();
                        $auxCantidadLibros = 0;
                    }
                }
            }

            $inventarios = Inventory::where('id_producto', $value)
            ->orderBy('id_bodega')
            ->get();

            $auxCantidadLibros = $cantidadLibros;
            foreach ($inventarios as $inventario) {
                if ($auxCantidadLibros != 0) {
                    if ($auxCantidadLibros >= $inventario->stock_actual) {
                        $aux_stock_actual = $inventario->stock_actual;
                        $auxCantidadLibros -= $inventario->stock_actual;
                        $inventario->stock_actual = 0;
                        $inventario->save();

                        DB::table('movimiento_inventario')->insert([
                            'id_inventario' => $inventario->id_inventario,
                            'id_tipo_movimiento' => 4,
                            'nro_documento' => $detalle_orden_venta->id_detalle_orden_venta,
                            'fecha' => date('Ymd'),
                            'descripcion' => 'VENTA LIBRO',
                            'entrada' => 0,
                            'salida' => $aux_stock_actual,
                            'id_usuario' => auth()->user()->id,
                            'id_documento' => $documento->id_documento
                        ]);
                    } else {
                        $aux_cantidad_libros_movimiento = $auxCantidadLibros;
                        $inventario->stock_actual = $inventario->stock_actual - $auxCantidadLibros;
                        $inventario->save();
                        $auxCantidadLibros = 0;

                        DB::table('movimiento_inventario')->insert([
                            'id_inventario' => $inventario->id_inventario,
                            'id_tipo_movimiento' => 4,
                            'nro_documento' => $detalle_orden_venta->id_detalle_orden_venta,
                            'fecha' => date('Ymd'),
                            'descripcion' => 'VENTA LIBRO',
                            'entrada' => 0,
                            'salida' => $aux_cantidad_libros_movimiento,
                            'id_usuario' => auth()->user()->id,
                            'id_documento' => $documento->id_documento
                        ]);
                    }
                }
            }
        }

        return redirect()->route('home')->with('status', 'Se registró la venta exitosamente con ' . $documento->nombre . ' N°' . $orden_venta->numero_documento);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function close($fecha = null)
    {
        $fecha = is_null($fecha) ? date('Ymd') : $fecha;
        $total_amount = 0;
        $ventas = Orden_venta::select(DB::raw('forma_pago.nombre, count(detalle_forma_pago.monto) as count, sum(detalle_forma_pago.monto) as suma'))
        ->join('detalle_forma_pago', 'orden_venta.id_orden_venta', '=', 'detalle_forma_pago.id_orden_venta')
        ->join('forma_pago', 'detalle_forma_pago.id_forma_pago', '=', 'forma_pago.id_forma_pago')
        ->where('orden_venta.fecha_documento', 'like', $fecha . "%")
        ->groupBy('forma_pago.nombre')->get();

        foreach ($ventas as $value) {
            $total_amount += $value->suma;
        }

        $time = strtotime($fecha);
        $fecha = date('Y-m-d', $time);


        return view('orders.close', compact('ventas', 'total_amount', 'fecha'));
    }

    public function getSales($fecha)
    {
        $ventas = Orden_venta::select(DB::raw('forma_pago.nombre, count(detalle_forma_pago.monto) as count, sum(detalle_forma_pago.monto) as suma'))
            ->join('detalle_forma_pago', 'orden_venta.id_orden_venta', '=', 'detalle_forma_pago.id_orden_venta')
            ->join('forma_pago', 'detalle_forma_pago.id_forma_pago', '=', 'forma_pago.id_forma_pago')
            ->where('orden_venta.fecha_documento', 'like', $fecha . "%")
            ->groupBy('forma_pago.nombre')->get();

        return $ventas;
    }

    public function getDocumentsResume($fecha)
    {
        $documents_resume = Detalle_forma_pago::whereHas(
            'ordenVenta', function ($query) use ($fecha) {
                $query->where('fecha_documento', 'like', $fecha . "%");
            })
            ->with(['formaPago', 'ordenVenta', 'ordenVenta.document'])
            ->orderBy('id_orden_venta', 'desc')
            ->get();

        return $documents_resume;
    }

    public function documentos()
    {
        return Document::where('venta_pos', 1)->get();
    }

    public function formasPago()
    {
        return Forma_pago::get();
    }
}
