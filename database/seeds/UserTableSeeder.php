<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::create([
    		'name' => 'admin',
    		'email' => 'samuellopezrosales101@gmail.com',
    		'password' => bcrypt('Barcelona#123'),
    		'dni' => '12345678',
    		'address' => '',
    		'phone' => '',
    		'role' => 'admin'
    	]);
        factory(User::class,50)->create();
    }
}
