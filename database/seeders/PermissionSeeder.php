<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $iterator = json_decode(file_get_contents(database_path('backups/permissions.json')))[2]->data;
        foreach ($iterator as $item) {
            Permission::insert((array) $item);
        }
    }
}
