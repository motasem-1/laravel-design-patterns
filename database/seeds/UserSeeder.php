<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        'name'=>'motasem',
        'email' =>'motasem@app.com',
            'password' => bcrypt('12345678'),

    
        ]);
        User::create([
            'name' => 'ali',
            'email' => 'ali@app.com',
            'password' => bcrypt('12345678'),


        ]);
    }
}