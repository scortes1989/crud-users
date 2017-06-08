<?php

namespace Tests\Feature;

use App\Mail\CreatedUser;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    function testListsUsers()
    {
        Mail::fake();

        $user = factory(User::class)->create();

        factory(User::class, 5)->create();

        $this->actingAs($user, 'api')
            ->get('api/v1/core/users')
            ->assertStatus(200)
            ->assertJson([
                'data' => User::orderBy('name')->get()->toArray(),
            ]);

        Mail::assertSent(CreatedUser::class);
    }

    function testStoreAUser()
    {
        //cuando tengo 1 usuario y tengo 1 rol
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();

        //entonces enviare estos parametros

        $parameters = [
            'name' => 'sebastian',
            'email' => 'seba.cortes1989@gmail.com',
            'password' => 1234,
            'role_id' => $role->id,
            'birthday' => Carbon::now()->format('d/m/Y'),
        ];

        //ingreso a la url core/users por post
        $response = $this->actingAs($user)
            ->post('core/users', $parameters)
            ->assertStatus(302)
            ->assertRedirect('core/users');

        //entonces debo ver la url core/users

        //entonces en la bd deben estar los datos

        $this->assertDatabaseHas('users', [
            'name' => 'sebastian',
            'email' => 'seba.cortes1989@gmail.com',
            'role_id' => $role->id,
            'birthday' => Carbon::now()->format('Y-m-d'),
        ]);
    }

    function testValidateUserAStore()
    {
        //cuando tengo 1 usuario y tengo 1 rol
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();

        //ingreso a la url core/users por post
        $response = $this->actingAs($user)
            ->json('POST', 'core/users', [])
            ->assertStatus(422)
            ->assertSee('El nombre es obligatorio');
    }

    function testUpdateAUser()
    {

    }

    function testDeleteAUser()
    {

    }
}
