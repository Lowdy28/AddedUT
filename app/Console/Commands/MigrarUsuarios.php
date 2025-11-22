<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrarUsuarios extends Command
{
    protected $signature = 'migrar:usuarios';
    protected $description = 'Migra registros de la tabla users hacia usuarios';

    public function handle()
    {
        if (!DB::table('users')->count()) {
            $this->info('La tabla "users" no tiene registros.');
            return Command::SUCCESS;
        }

        $this->info('Iniciando migración de usuarios...');

        if (DB::table('usuarios')->count() > 0) {
            if (!$this->confirm(
                'La tabla "usuarios" ya tiene datos. ¿Deseas continuar y duplicarlos?',
                false
            )) {
                $this->info('Operación cancelada.');
                return Command::SUCCESS;
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $insertados = DB::table('usuarios')->insertUsing(
            ['id_usuario', 'nombre', 'correo', 'password', 'rol', 'fecha_registro', 'activo'],
            DB::table('users')->select([
                'id',
                'name',
                'email',
                'password',
                'role',
                DB::raw('NOW()'),
                DB::raw('1')
            ])
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info("Migración completada. Registros insertados: {$insertados}");

        return Command::SUCCESS;
    }
}
