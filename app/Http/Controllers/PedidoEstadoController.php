<?php

namespace App\Http\Controllers;

use App\Models\EstadoPedido;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;

// Actualizacion de pedido estado
use App\Models\PedidoEstado;

class PedidoEstadoController extends Controller
{
    public function listarEstados() {
        try {
            $estados = EstadoPedido::all();
            return response()->json([
                'data' => $estados,
                'message' => 'Se listó Estados de los pedidos correctamente',
                'error' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'message' => null,
                'error' => 'Error al listar los estados de los pedidos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function actualizarEstado(Request $request){
        $validated = $request->validate([
            'shopify_order_id' => 'required|numeric',
            'estado_pago' => 'nullable|in:pagado,pendiente',
            'estado_preparacion' => 'nullable|in:preparado,no_preparado',
        ]);

        $pedido = EstadoPedido::updateOrCreate(
            ['shopify_order_id' => $validated['shopify_order_id']],
            array_filter([
                'estado_pago' => $validated['estado_pago'] ?? null,
                'estado_preparacion' => $validated['estado_preparacion'] ?? null,
            ])
        );

        return response()->json([
            'message' => 'Estado actualizado correctamente',
            'data' => $pedido,
        ], 200);
    }

    public function obtenerEstado($shopify_order_id){
        $pedido = EstadoPedido::where('shopify_order_id', $shopify_order_id)->first();

        if (!$pedido) {
            return response()->json([
                'message' => 'No se encontró el pedido',
            ], 404);
        }

        return response()->json($pedido);
    }

    // Actualizacion de funciones para pedido estado

    public function updateEstados(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'shopify_order_id' => [
                'required',
                'integer',
                'exists:pedido_estado,shopify_order_id',
            ],
            'estado_shopify' => 'nullable|string|max:50',
            'estado_venta' => 'nullable|string|max:50',
            'estado_almacen' => 'nullable|string|max:50',
            'estado_delivery' => 'nullable|string|max:50',
        ]);

        $data = array_filter([
            'estado_shopify' => $validated['estado_shopify'] ?? null,
            'estado_venta' => $validated['estado_venta'] ?? null,
            'estado_almacen' => $validated['estado_almacen'] ?? null,
            'estado_delivery' => $validated['estado_delivery'] ?? null,
        ]);

        $pedidoEstado = PedidoEstado::updateOrCreate(
            ['shopify_order_id' => $validated['shopify_order_id']],
            $data
        );

        return response()->json([
            'message' => 'Estados actualizados correctamente',
            'data' => $pedidoEstado,
        ], 200);
    }

    public function getEstadoShopify($shopify_order_id): JsonResponse
    {
        $request = request()->merge(['shopify_order_id' => $shopify_order_id]);
        $validated = $request->validate([
            'shopify_order_id' => [
                'required',
                'integer',
                'exists:pedido_externo,shopify_order_id',
            ],
        ]);

        $pedidoEstado = PedidoEstado::where('shopify_order_id', $validated['shopify_order_id'])->first();

        return response()->json([
            'message' => 'Estado Shopify consultado correctamente',
            'data' => [
                'shopify_order_id' => $validated['shopify_order_id'],
                'estado_shopify' => $pedidoEstado ? $pedidoEstado->estado_shopify : null,
            ],
        ], 200);
    }

    public function getEstadoVenta($shopify_order_id): JsonResponse
    {
        $request = request()->merge(['shopify_order_id' => $shopify_order_id]);
        $validated = $request->validate([
            'shopify_order_id' => [
                'required',
                'integer',
                'exists:pedido_externo,shopify_order_id',
            ],
        ]);

        $pedidoEstado = PedidoEstado::where('shopify_order_id', $validated['shopify_order_id'])->first();

        return response()->json([
            'message' => 'Estado de venta consultado correctamente',
            'data' => [
                'shopify_order_id' => $validated['shopify_order_id'],
                'estado_venta' => $pedidoEstado ? $pedidoEstado->estado_venta : null,
            ],
        ], 200);
    }

    public function getEstadoAlmacen($shopify_order_id): JsonResponse
    {
        $request = request()->merge(['shopify_order_id' => $shopify_order_id]);
        $validated = $request->validate([
            'shopify_order_id' => [
                'required',
                'integer',
                'exists:pedido_externo,shopify_order_id',
            ],
        ]);

        $pedidoEstado = PedidoEstado::where('shopify_order_id', $validated['shopify_order_id'])->first();

        return response()->json([
            'message' => 'Estado de almacén consultado correctamente',
            'data' => [
                'shopify_order_id' => $validated['shopify_order_id'],
                'estado_almacen' => $pedidoEstado ? $pedidoEstado->estado_almacen : null,
            ],
        ], 200);
    }

    public function getEstadoDelivery($shopify_order_id): JsonResponse
    {
        $request = request()->merge(['shopify_order_id' => $shopify_order_id]);
        $validated = $request->validate([
            'shopify_order_id' => [
                'required',
                'integer',
                'exists:pedido_externo,shopify_order_id',
            ],
        ]);

        $pedidoEstado = PedidoEstado::where('shopify_order_id', $validated['shopify_order_id'])->first();

        return response()->json([
            'message' => 'Estado de delivery consultado correctamente',
            'data' => [
                'shopify_order_id' => $validated['shopify_order_id'],
                'estado_delivery' => $pedidoEstado ? $pedidoEstado->estado_delivery : null,
            ],
        ], 200);
    }
}
