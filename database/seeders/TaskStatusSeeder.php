<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['backlog', 'in progress', 'paused', 'done'];

        foreach ($names as $name) {
            TaskStatus::query()->create([
                'name' => $name,
                'slug_name' => Str::of($name)->slug('-'),
            ]);
        }
    }
}
