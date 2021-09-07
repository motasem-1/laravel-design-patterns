<?php

use App\Post;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->delete();

        $faker = Factory::create();



        for ($i = 0; $i < 20; $i++) {
            $posts = new Post();

            $posts->title = $faker->sentence(4);
            $posts->body = $faker->paragraph(5);
            $posts->user_id = User::all()->unique()->random()->id;
            $posts->save();
        }
    }
}