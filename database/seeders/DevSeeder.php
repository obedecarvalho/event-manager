<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->command->info('Creating Categories...');
        Category::factory()
            ->count(10)
            ->create();

        $this->command->info('Creating Events...');
        $events = Event::factory()
            ->count(50)
            ->create();

        $this->command->info('Assigning Categories to Events...');
        foreach($events as $event){
            $categories = Category::inRandomOrder()->limit(fake()->numberBetween(1, 3));
            $event->categories()->attach($categories->pluck('id'));
        }
    }
}
