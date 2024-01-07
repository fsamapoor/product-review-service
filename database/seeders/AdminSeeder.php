<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    const string ADMIN_EMAIL = 'admin@fsamapoor.dev';

    public function run(): void
    {
        User::query()->firstOrCreate(
            [
                'email' => self::ADMIN_EMAIL,
            ],
            [
                'name' => 'admin',
                'password' => 'FilamentRocks!',
            ]
        );
    }
}
