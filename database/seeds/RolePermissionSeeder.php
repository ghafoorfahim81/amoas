<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {

        // Define resources
        $resources = [
            'booking',
            'package',
            'holiday',
            'traceable',
            'setting',
            'user_management', 
            'dashboard',
        ];

        // Define actions
        $default_actions = ['create', 'edit', 'list', 'delete', 'view'];

        $resource_actions_map = [
            'reports' => ['reports', 'export'],
            'booking' => ['create', 'list', 'edit', 'delete', 'view', 'cancel', 'approve'],
            'dashboard' => ['simple', 'advance'],
        ];

        $permissions = [];

        foreach ($resources as $resource) {
            $actions = $resource_actions_map[$resource] ?? $default_actions;

            foreach ($actions as $action) {
                $permissions[] = "{$action}_{$resource}";
            }
        }


        // Insert permissions into the database
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $user = Role::firstOrCreate(['name' => 'user']);

        $labTechnician = Role::firstOrCreate(['name' => 'lab_technician']);

        $labPermissions = Permission::where(function ($query) {
            $query->where('name', 'add_test_results_sample') ;
        })->where('name', '!=', 'simple_dashboard')->get();

        $labTechnician->givePermissionTo($labPermissions);

        // Assign all permissions to Super Admin
        $superAdmin->givePermissionTo(Permission::all());

        // Assign permissions to Admin (excluding restricted ones)
        $adminPermissions = Permission::whereNotIn('name', [
            'delete_user_management',
            'create_administration',
            'edit_administration',
            'list_administration',
            'delete_administration',
        ])->get();
        $admin->syncPermissions($adminPermissions);

        // Assign limited permissions to Editor (only edit, view_list, and view)
        $editorPermissions = Permission::where(function ($query) {
            $query->where('name', 'like', 'edit_%')
                ->orWhere('name', 'like', 'list_%')
                ->orWhere('name', 'like', 'view_%');
        })->where('name', '!=', 'list_reports')->get();
        $editor->syncPermissions($editorPermissions);

        // Assign minimal permissions to User (only view_list and view)
        $userPermissions = Permission::where(function ($query) {
            $query->where('name', 'like', 'list_%')
                ->orWhere('name', 'like', 'view_%');
        })->where('name', '!=', 'list_reports')->get();
        $user->syncPermissions($userPermissions);

        // Assign only 'list_reports' permission for reports to all roles
        Permission::where('name', 'list_reports')->each(function ($permission) use ($admin, $editor, $user) {
            $admin->givePermissionTo($permission);
            $editor->givePermissionTo($permission);
            $user->givePermissionTo($permission);
        });
    }
}
