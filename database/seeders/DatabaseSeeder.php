<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Guestbook;
use App\Models\HallOfFame;
use App\Models\Member;
use App\Models\Project;
use App\Models\Quote;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users (Admin & Developer only)
        User::create([
            'name' => 'Developer A4A',
            'email' => 'developer@a4a.com',
            'password' => Hash::make('password'),
            'role' => 'developer',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Admin A4A',
            'email' => 'admin@a4a.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);
    }
}
