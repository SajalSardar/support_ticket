<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $iterator = json_decode(file_get_contents(database_path('backups/menus.json')))[2]->data;
        foreach ($iterator as $item) {
            Menu::insert((array) $item);
        }
    }
}
