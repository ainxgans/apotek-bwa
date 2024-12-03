<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $ownerRole = Role::create([
            'name' => 'owner'
        ]);

        $buyerRole = Role::create([
            'name' => 'buyer'
        ]);
        $user = User::create([
            'name'=> 'Maulana',
            'email' => 'maulana@owner.com',
            'password' => bcrypt('qwaszxer')
        ]);

        $user->assignRole($ownerRole);
    }
}
