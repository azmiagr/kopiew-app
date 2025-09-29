<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Thread;

class ThreadSeeder extends Seeder
{
    public function run(): void
    {
        Thread::create([
            'user_id' => 1,
            'content' => 'Nongkrong di kafe hidden gem nih!',
            'image' => null,
        ]);

        Thread::create([
            'user_id' => 1,
            'content' => 'Ada event musik seru di Kopi Senja!',
            'image' => null,
        ]);
    }
}
