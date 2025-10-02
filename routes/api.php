<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopifyController;
use App\Http\Controllers\PedidoEstadoController;
use App\Http\Controllers\NotificacionAlmacenController;


Route::get('/shopify/orders', [ShopifyController::class, 'getOrders']);
Route::get('/shopify/locations', [ShopifyController::class, 'obtenerUbicaciones']);
Route::post('/shopify/fulfill/{orderId}', [ShopifyController::class, 'fulfillOrder']);
Route::get('shopify/orders/{orderId}.json', [ShopifyController::class, 'getOrderById']);
Route::post('/shopify/pedidos/{id}/pagar', [ShopifyController::class, 'marcarComoPagado']);


//rutas del api estado de pedidos
Route::post('/estado-pedido', [PedidoEstadoController::class, 'actualizarEstado']);
Route::get('/estado-pedido/{shopify_order_id}', [PedidoEstadoController::class, 'obtenerEstado']);
Route::get('/estado-pedido-todos', [PedidoEstadoController::class, 'listarEstados']); 

//rutas del api notificaciones
Route::post('/notificaciones/almacen', [NotificacionAlmacenController::class, 'store']);
Route::get('/notificaciones/almacen', [NotificacionAlmacenController::class, 'index']);
Route::post('/notificaciones/almacen/{id}/leido', [NotificacionAlmacenController::class, 'marcarLeido']);