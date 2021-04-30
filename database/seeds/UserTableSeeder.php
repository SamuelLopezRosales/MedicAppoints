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
        User::create([
            'name' => 'medico',
            'email' => 'samy-messi10@hotmail.com',
            'password' => bcrypt('Barcelona#123'),
            'dni' => '12345678',
            'address' => '',
            'phone' => '',
            'role' => 'doctor'
        ]);
        User::create([
            'name' => 'Paciente',
            'email' => 'paciente@paciente.com',
            'password' => bcrypt('Barcelona#123'),
            'dni' => '12345678',
            'address' => '',
            'phone' => '',
            'role' => 'patient'
        ]);
        factory(User::class,50)->states('patient')->create();
    }
}
