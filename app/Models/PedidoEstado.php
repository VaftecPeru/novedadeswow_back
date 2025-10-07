<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoEstado extends Model
{
    use HasFactory;

    protected $table = 'pedido_estado';

    protected $fillable = [
        'shopify_order_id',
        'estado_shopify',
        'estado_venta',
        'estado_almacen',
        'estado_delivery',
    ];

    // Relación: Un PedidoEstado pertenece a un PedidoExterno
    public function pedidoExterno(): BelongsTo
    {
        return $this->belongsTo(PedidoExterno::class, 'shopify_order_id', 'shopify_order_id');
    }
}