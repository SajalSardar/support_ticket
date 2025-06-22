<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Module;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            class: [
                UserSeeder::class,
                MenuSeeder::class,
                ModuleSeeder::class,
                PermissionSeeder::class
            ]
        );
    }
}
