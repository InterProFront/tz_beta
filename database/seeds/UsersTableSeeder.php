<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => 'Roman',
            'email' => 'demigod96@bk.ru',
            'password' => bcrypt('Rjcfyjcnhf'),
            'fio' => 'Кабиров Роман',
            'avatar' => '/img/avatar.jpg',
        ]);
    }
}
