<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Limpia la caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permisos existentes para el manejo de tickets
        $ticketPermissions = [
            'ticket.view',
            'ticket.create',
            'ticket.edit',
            'ticket.delete',
        ];

        foreach ($ticketPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Permiso adicional para el dashboard
        Permission::firstOrCreate(['name' => 'view.dashboard']);

        // Rol de administrador (ya creado en ejemplo anterior)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        // Usuario administrador
        $adminUser = User::firstOrCreate(
            ['email' => 'jefesistemas@tvs.edu.co'],
            [
                'name' => 'Jefe de Sistemas',
                'password' => Hash::make('Cr1st1an2024*'),
            ]
        );
        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole($adminRole);
        }

        // Crear el rol "usuario" y asignar solo view.dashboard y ticket.view
        $usuarioRole = Role::firstOrCreate(['name' => 'usuario']);
        $usuarioRole->syncPermissions([
            Permission::firstOrCreate(['name' => 'view.dashboard']),
            Permission::firstOrCreate(['name' => 'ticket.view']),
        ]);
    }
}
