<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['farang', 'japan', 'bangkok', 'park'];
        foreach ($tags as $tag) App\Tag::create(['tag_name' => $tag]);
    }
}
