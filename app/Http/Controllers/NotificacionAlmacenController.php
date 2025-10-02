<?php
namespace App\Http\Controllers;

use App\Models\NotificacionAlmacen;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NotificacionAlmacenController extends Controller
{
    // Crear notificación
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shopify_order_id' => 'required|numeric',
            'mensaje' => 'required|string',
            'tipo' => 'nullable|string',
        ]);

        $notificacion = NotificacionAlmacen::create([
            'shopify_order_id' => $validated['shopify_order_id'],
            'mensaje' => $validated['mensaje'],
            'tipo' => $validated['tipo'] ?? 'PAGO_CONFIRMADO',
        ]);

        return response()->json([
            'message' => 'Notificación creada',
            'data' => $notificacion,
        ], 201);
    }

    // Listar notificaciones
    public function index()
    {
        return NotificacionAlmacen::orderBy('created_at', 'desc')->get();
    }

    // Marcar notificación como leido
    public function marcarLeido($id)
    {
        $notificacion = NotificacionAlmacen::findOrFail($id);
        $notificacion->leido = true;
        $notificacion->save();

        return response()->json(['message' => 'Notificación marcada como leída']);
    }
}