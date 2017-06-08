<?php

use App\Models\Role;
use App\Models\User;
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
        User::create([
            'name' => 'sebastian',
            'email' => 'seba.cortes1989@gmail.com',
            'password' => '1234',
            'role_id' => Role::find(1)->id,
            'api_token' => str_random(100),
        ]);

        factory(User::class, 5)->create();
    }
}
