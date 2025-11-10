<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);
        Role::create(['name' => 'employee']);

        $permissions = [
            'view users', 'create users', 'edit users', 'delete users', 'lock user',
        ];

        foreach ($permissions as $perm) {
            Permission::create(['name' => $perm]);
        }

        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo(['view users']);
    }
}
