<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Enum\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DevUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating Users...');

        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@eventmanager.com',
            'password' => 'eventmanager',
        ]);
        $admin->assignRole(Roles::ADMIN->name);

        $admin = User::factory()->create([
            'name' => 'content manager',
            'email' => 'content_manager@eventmanager.com',
            'password' => 'eventmanager',
        ]);
        $admin->assignRole(Roles::CONTENT_MANAGER->name);

        $admin = User::factory()->create([
            'name' => 'user manager',
            'email' => 'user_manager@eventmanager.com',
            'password' => 'eventmanager',
        ]);
        $admin->assignRole(Roles::USER_MANAGER->name);

        $admin = User::factory()->create([
            'name' => 'metadata manager',
            'email' => 'metadata_manager@eventmanager.com',
            'password' => 'eventmanager',
        ]);
        $admin->assignRole(Roles::METADATA_MANAGER->name);

        $admin = User::factory()->create([
            'name' => 'user',
            'email' => 'user@eventmanager.com',
            'password' => 'eventmanager',
        ]);

    }
}
