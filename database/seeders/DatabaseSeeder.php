<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Modules\Identity\Enums\Status;
use App\Modules\Identity\Models\User;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Steve McDougall',
            'handle' => 'juststeveking',
            'email' => 'juststevemcd@gmail.com',
            'status' => Status::Verified,
        ]);
    }
}
