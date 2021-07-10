<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::updateOrCreate([
            'title' => 'Welcome',
            'slug' => 'welcome',
            'body' => 'This is welcome page',
        ]);
        Page::updateOrCreate([
            'title' => 'Get Consultation',
            'slug' => 'get-consultation',
            'body' => 'This is welcome page',
        ]);
    }
}
