<?php

namespace App\Http\Controllers;

use App\Models\SeguimientoPedido;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SeguimientoPedidoController extends Controller
{
    public function historial($shopify_order_id): JsonResponse
    {
        $historial = SeguimientoPedido::where('shopify_order_id', $shopify_order_id)
            ->orderBy('created_at', 'asc')
            ->with('responsable')
            ->get();

        return response()->json([
            'message' => 'Historial obtenido correctamente',
            'data' => $historial,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $seguimiento = SeguimientoPedido::create([
            'shopify_order_id' => $request->shopify_order_id,
            'area' => $request->area,
            'estado' => $request->estado,
            'responsable_id' => $request->responsable_id,
        ]);

        return response()->json([
            'message' => 'Seguimiento guardado correctamente',
            'data' => $seguimiento->load('responsable'),
        ], 201);
    }

     public function getAdministracionSeguimientos(): JsonResponse
    {
        $seguimientos = SeguimientoPedido::where('area', 'administracion')
            ->whereNotNull('responsable_id')
            ->with(['responsable' => function ($query) {
                $query->select('id', 'nombre_completo');
            }])
            ->get();

        return response()->json([
            'message' => 'Seguimientos de administracion obtenidos correctamente',
            'data' => $seguimientos,
        ], 200);
    }


    public function getVentasSeguimientos(): JsonResponse
    {
        $seguimientos = SeguimientoPedido::where('area', 'ventas')
            ->whereNotNull('responsable_id')
            ->with(['responsable' => function ($query) {
                $query->select('id', 'nombre_completo');
            }])
            ->get();

        return response()->json([
            'message' => 'Seguimientos de ventas obtenidos correctamente',
            'data' => $seguimientos,
        ], 200);
    }

    public function getAlmacenSeguimientos(): JsonResponse
    {
        $seguimientos = SeguimientoPedido::where('area', 'Almacen')
            ->whereNotNull('responsable_id')
            ->with(['responsable' => function ($query) {
                $query->select('id', 'nombre_completo');
            }])
            ->get();

        return response()->json([
            'message' => 'Seguimientos de almacen obtenidos correctamente',
            'data' => $seguimientos,
        ], 200);
    }

    public function getDeliverySeguimientos(): JsonResponse
    {
        $seguimientos = SeguimientoPedido::where('area', 'Delivery')
            ->whereNotNull('responsable_id')
            ->with(['responsable' => function ($query) {
                $query->select('id', 'nombre_completo');
            }])
            ->get();

        return response()->json([
            'message' => 'Seguimientos de delivery obtenidos correctamente',
            'data' => $seguimientos,
        ], 200);
    }
}
