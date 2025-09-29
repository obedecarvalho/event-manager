<?php

namespace Database\Seeders;

use App\Support\Enum\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => Roles::ADMIN->name]);

        Role::create(['name' => Roles::CONTENT_MANAGER->name]);

        Role::create(['name' => Roles::USER_MANAGER->name]);

        Role::create(['name' => Roles::METADATA_MANAGER->name]);
    }
}
