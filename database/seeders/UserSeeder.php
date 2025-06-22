<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name'              => 'Super Admin',
            'email'             => "superadmin@gmail.com",
            'email_verified_at' => now(),
            'password'          => Hash::make('password@987'),
            'remember_token'    => Str::random(10),
        ]);
        $userAdmin = User::factory()->create([
            'name'              => 'Admin',
            'email'             => "admin@gmail.com",
            'email_verified_at' => now(),
            'password'          => Hash::make('password@987'),
            'remember_token'    => Str::random(10),
        ]);

        $agentUser = User::factory()->create([
            'name'              => 'Agent',
            'email'             => "agent@gmail.com",
            'email_verified_at' => now(),
            'password'          => Hash::make('password@987'),
            'remember_token'    => Str::random(10),
        ]);

        $requesterUser = User::factory()->create([
            'name'              => 'Requester',
            'email'             => "requester@gmail.com",
            'email_verified_at' => now(),
            'password'          => Hash::make('password@987'),
            'remember_token'    => Str::random(10),
        ]);

        $role      = Role::create(['name' => 'super-admin']);
        $admin     = Role::create(['name' => 'admin']);
        $agent     = Role::create(['name' => 'agent']);
        $requester = Role::create(['name' => 'requester']);

        $user->assignRole($role);
        $userAdmin->assignRole($admin);
        $agentUser->assignRole($agent);
        $requesterUser->assignRole($requester);
    }
}
