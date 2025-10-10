<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(): JsonResponse
    {
        $usuarios = Usuario::with('rol')->get(['id', 'nombre_completo', 'correo', 'rol_id']);

        return response()->json([
            'message' => 'Usuarios obtenidos correctamente',
            'data' => $usuarios,
        ], 200);
    }

    public function vendedores(): JsonResponse
    {
        $vendedores = Usuario::whereHas('rol', function ($query) {
            $query->where('nombre', 'vendedor');
        })->get(['id', 'nombre_completo', 'correo', 'rol_id']);

        return response()->json([
            'message' => 'Vendedores obtenidos correctamente',
            'data' => $vendedores,
        ], 200);
    }

    public function almacen(): JsonResponse
    {
        $almacen = Usuario::whereHas('rol', function ($query) {
            $query->where('nombre', 'almacen');
        })->get(['id', 'nombre_completo', 'correo', 'rol_id']);

        return response()->json([
            'message' => 'Usuarios de almacén obtenidos correctamente',
            'data' => $almacen,
        ], 200);
    }

    public function delivery(): JsonResponse
    {
        $delivery = Usuario::whereHas('rol', function ($query) {
            $query->where('nombre', 'delivery');
        })->get(['id', 'nombre_completo', 'correo', 'rol_id']);

        return response()->json([
            'message' => 'Usuarios de delivery obtenidos correctamente',
            'data' => $delivery,
        ], 200);
    }
}