<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoEstadoTable extends Migration
{
    public function up()
    {
        Schema::create('pedido_estado', function (Blueprint $table) {
            // Clave primaria con auto-incremento
            $table->bigIncrements('id');

            // Campo shopify_order_id con clave única
            $table->unsignedBigInteger('shopify_order_id')->unique();

            // Campos de estado con valores por defecto NULL
            $table->string('estado_shopify', 50)->nullable();
            $table->string('estado_venta', 50)->nullable();
            $table->string('estado_almacen', 50)->nullable();
            $table->string('estado_delivery', 50)->nullable();

            // Campos de auditoría
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedido_estado');
    }
}