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
        $ticketPermissions = 
        [
            'view.dashboard',
            'ticket.view',
            'ticket.edit',
            'ticket.delete',
            'ticket.show',
            'documents',
            'document-requests',
            'kpis.enfermeria.create',
            'kpis.enfermeria.index',
            'umbral.enfermeria.create',
            'umbral.enfermeria.show',
            'kpis.compras.create',
            'kpis.compras.index',
            'umbral.compras.create',
            'umbral.compras.show',
            'kpis.recursoshumanos.create',
            'kpis.recursoshumanos.index',
            'umbral.recursoshumanos.create',
            'umbral.recursoshumanos.show',
            'kpis.sistemas.create',
            'kpis.sistemas.index',
            'umbral.sistemas.create',
            'umbral.sistemas.index',
            'view.roles',
            'view.users',

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
            ['email' => env('ADMIN_EMAIL')],
            [
                'name' => env('ADMIN_NAME'),
                'password' => Hash::make(env('ADMIN_PASSWORD')),
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
            Permission::firstOrCreate(['name' => 'document-requests']),
        ]);
    }
}
