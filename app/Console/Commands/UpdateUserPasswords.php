<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UpdateUserPasswords extends Command
{
    protected $signature = 'users:update-passwords';
    protected $description = 'Actualiza las contraseñas de los usuarios a Bcrypt';

    public function handle()
    {
        // Lista de contraseñas originales (ajusta según tu fuente)
        $passwords = [
            ['correo' => 'ventas@novedadeswow.com', 'contraseña' => 'ventas12345'],
            ['correo' => 'almacen@novedadeswow.com', 'contraseña' => 'almacen12345'],
            ['correo' => 'delivery@novedadeswow.com', 'contraseña' => 'delivery12345'],
            ['correo' => 'administracion@novedadeswow.com', 'contraseña' => 'administracion2345'],
           
        ];

        foreach ($passwords as $data) {
            $usuario = Usuario::where('correo', $data['correo'])->first();
            if ($usuario) {
                $this->info("Actualizando contraseña para {$usuario->correo}");
                $usuario->contraseña = Hash::make($data['contraseña']);
                $usuario->save();
            } else {
                $this->warn("Usuario no encontrado: {$data['correo']}");
            }
        }

        $this->info('Contraseñas actualizadas correctamente.');
    }
}