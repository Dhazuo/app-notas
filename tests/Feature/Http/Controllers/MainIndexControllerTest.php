<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MainIndexControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_main_index_guest()
    {
        $this->get('/')->assertStatus(200);
    }

    //assert redirect on logged user
    public function test_accessing_notes()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('/')
            ->assertRedirect('/notes');
    }

    //assert error on user doesnt exists
    public function test_user_doesnt_exists()
    {
        $user = User::factory()->create();

        $data = [
            'email' => $this->faker->email,
            'password' => $this->faker->password
        ];

        $this
            ->post('/', $data)
            ->assertStatus(404);
    }

    //validation
    public function test_login_validation()
    {
        $this
            ->post('/', [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['email', 'password']);
    }
}
