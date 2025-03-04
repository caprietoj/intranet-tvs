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
            'equipment.manage',
            'equipment.reset',
            'equipment.inventory',
            'equipment.reserva',
            'view.reservas',
            'view.reservations',
            'view.events',
            'view.reports',
            'view.upload',
            'kpis.contabilidad.create',
            'kpis.contabilidad.index',
            'umbral.contabilidad.create',
            'umbral.contabilidad.show',
            'view.kpis',
            'view.budget',
            'view.announcements',
            'view.calendar',
            'view.maintenance',
            'view-admin-dashboard',
            'manage.configuration',
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
            Permission::firstOrCreate(['name' => 'view.maintenance']),
        ]);

         // Crear el rol "enfermeria"
         $usuarioRole = Role::firstOrCreate(['name' => 'enfermeria']);
         $usuarioRole->syncPermissions([
             Permission::firstOrCreate(['name' => 'view.dashboard']),
             Permission::firstOrCreate(['name' => 'ticket.view']),
             Permission::firstOrCreate(['name' => 'document-requests']),
             Permission::firstOrCreate(['name' => 'kpis.enfermeria.create']),
             Permission::firstOrCreate(['name' => 'kpis.enfermeria.index']),
             Permission::firstOrCreate(['name' => 'umbral.enfermeria.create']),
             Permission::firstOrCreate(['name' => 'umbral.enfermeria.show']),
             Permission::firstOrCreate(['name' => 'view.kpis']),
             Permission::firstOrCreate(['name' => 'view.maintenance']),


         ]);

          // Crear el rol "contabilidad"
        $usuarioRole = Role::firstOrCreate(['name' => 'contabilidad']);
        $usuarioRole->syncPermissions([
            Permission::firstOrCreate(['name' => 'view.dashboard']),
            Permission::firstOrCreate(['name' => 'ticket.view']),
            Permission::firstOrCreate(['name' => 'document-requests']),
            Permission::firstOrCreate(['name' => 'view.budget']),
            Permission::firstOrCreate(['name' => 'Ejecución Presupuestal']),
            Permission::firstOrCreate(['name' => 'Registrar Presupuesto']),
            Permission::firstOrCreate(['name' => 'view.maintenance']),

        ]);

         // Crear el rol "compras"
         $usuarioRole = Role::firstOrCreate(['name' => 'compras']);
         $usuarioRole->syncPermissions([
             Permission::firstOrCreate(['name' => 'view.dashboard']),
             Permission::firstOrCreate(['name' => 'ticket.view']),
             Permission::firstOrCreate(['name' => 'document-requests']),
             Permission::firstOrCreate(['name' => 'kpis.compras.create']),
             Permission::firstOrCreate(['name' => 'kpis.compras.index']),
             Permission::firstOrCreate(['name' => 'umbral.compras.create']),
             Permission::firstOrCreate(['name' => 'umbral.compras.show']),
             Permission::firstOrCreate(['name' => 'view.kpis']),
             Permission::firstOrCreate(['name' => 'view.maintenance']),
         ]);

          // Crear el rol "rrhh"
        $usuarioRole = Role::firstOrCreate(['name' => 'rrhh']);
        $usuarioRole->syncPermissions([
            Permission::firstOrCreate(['name' => 'view.dashboard']),
            Permission::firstOrCreate(['name' => 'ticket.view']),
            Permission::firstOrCreate(['name' => 'document-requests']),
            Permission::firstOrCreate(['name' => 'kpis.recursoshumanos.create']),
            Permission::firstOrCreate(['name' => 'kpis.recursoshumanos.index']),
            Permission::firstOrCreate(['name' => 'umbral.recursoshumanos.create']),
            Permission::firstOrCreate(['name' => 'umbral.recursoshumanos.show']),
            Permission::firstOrCreate(['name' => 'view.kpis']),
            Permission::firstOrCreate(['name' => 'documents']),
            Permission::firstOrCreate(['name' => 'document-requests']),
            Permission::firstOrCreate(['name' => 'view.maintenance']),

        ]);

         // Crear el rol "profesor"
         $usuarioRole = Role::firstOrCreate(['name' => 'profesor']);
         $usuarioRole->syncPermissions([
             Permission::firstOrCreate(['name' => 'view.dashboard']),
             Permission::firstOrCreate(['name' => 'ticket.view']),
             Permission::firstOrCreate(['name' => 'document-requests']),
             Permission::firstOrCreate(['name' => 'equipment.reserva']),
             Permission::firstOrCreate(['name' => 'view.reservas']),
             Permission::firstOrCreate(['name' => 'view.maintenance']),
         ]);

         $usuarioRole = Role::firstOrCreate(['name' => 'mantenimiento']);
         $usuarioRole->syncPermissions([
             Permission::firstOrCreate(['name' => 'view.dashboard']),
             Permission::firstOrCreate(['name' => 'ticket.view']),
             Permission::firstOrCreate(['name' => 'document-requests']),
             Permission::firstOrCreate(['name' => 'view.maintenance']),
         ]);

         $usuarioRole = Role::firstOrCreate(['name' => 'asistentes']);
         $usuarioRole->syncPermissions([
             Permission::firstOrCreate(['name' => 'view.dashboard']),
             Permission::firstOrCreate(['name' => 'ticket.view']),
             Permission::firstOrCreate(['name' => 'document-requests']),
             Permission::firstOrCreate(['name' => 'view.maintenance']),
             permission::firstOrCreate(['name' => 'view.events']),
             permission::firstOrCreate(['name' => 'view.calendar']),

         ]);

         $usuarioRole = Role::firstOrCreate(['name' => 'technician']);
         $usuarioRole->syncPermissions([
            Permission::firstOrCreate(['name' => 'view.dashboard']),
            Permission::firstOrCreate(['name' => 'ticket.view']),
            Permission::firstOrCreate(['name' => 'document-requests']),
            Permission::firstOrCreate(['name' => 'view.maintenance']),

         ]);
    }
}
