<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\Assert;
use Tests\TestCase;

class NoteCategoryControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_categories_guest()
    {
        $this->get('notes/per-categories')->assertRedirect('login');
    }


    //index
    public function test_categories_index_with_data()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create([
            'user_id' => $user->id
        ]);

        $this
            ->actingAs($user)
            ->get('notes/per-categories')
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                return $page
                    ->component('NotesPages/CategoryIndex')
                    ->has('notes', 1);
            }
            );
    }

    public function test_categories_index_without_data()
    {
        $note = Note::factory()->create();
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('notes/per-categories')
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                return $page
                    ->component('NotesPages/CategoryIndex')
                    ->has('notes', 0);
            }
            );
    }
}
