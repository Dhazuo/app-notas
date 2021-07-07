<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Inertia\Testing\Assert;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NoteControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guest()
    {
        $this->get('notes')->assertRedirect('login');                 // index
        $this->get('notes/1')->assertRedirect('login');               // show
        $this->get('notes/1/edit')->assertRedirect('login');          // edit
        $this->put('notes/1')->assertRedirect('login');               // update
        $this->delete('notes/1')->assertRedirect('login');            // delete
        $this->get('notes/create')->assertRedirect('login');          // create
        $this->post('notes', [])->assertRedirect('login');            // store
    }

    public function test_index_with_data()
    {
        $user = User::factory()->create();
        Note::factory()->create([
            'user_id' => $user->id,
        ]);

        $this
            ->actingAs($user)
            ->get('notes')
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                return $page
                    ->component('NotesPages/Index')
                    ->has('notes', 1);  //como solo hicimos un factory, esto indica que existe un elemento
            });
    }

    public function test_index_without_data()
    {
        Note::factory()->create();
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('notes')
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                return $page
                    ->component('NotesPages/Index')
                    ->has('notes', 0);
            });
    }

    public function test_show()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create([
            'user_id' => $user->id
        ]);

        $this
            ->actingAs($user)
            ->get("notes/$note->id")
            ->assertStatus(200)
            ->assertInertia(function (Assert $page){
                return $page
                    ->component('NotesPages/Show')
                    ->has('note')
                    ->where('note.id', 1);
            });
    }

    public function test_create()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('notes/create')
            ->assertStatus(200);
    }

    public function test_store()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $data = [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => $this->faker->title,
            'content' => $this->faker->text
        ];

        $this
            ->actingAs($user)
            ->post('notes', $data)
            ->assertJson([$data])
            ->assertStatus(200);

        $this->assertDatabaseHas('notes', $data);
    }

    public function test_edit()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create([
           'user_id' => $user->id
        ]);

        $this
            ->actingAs($user)
            ->get("notes/$note->id/edit")
            ->assertStatus(200);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $note = Note::factory()->create([
            'user_id' => $user->id
        ]);

        $data = [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => $this->faker->title,
            'content' => $this->faker->text
        ];

        $this
            ->actingAs($user)
            ->put("notes/$note->id", $data)
            ->assertJson([$data])
            ->assertStatus(200);

        $this
            ->assertDatabaseHas('notes', $data);
    }

    public function test_delete()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create([
            'user_id' => $user->id
        ]);

        $this
            ->actingAs($user)
            ->delete("notes/$note->id")
            ->assertJson(['message' => 'Deleted successfully'])
            ->assertStatus(200);

        $this->assertDatabaseMissing('notes', [$note]);
    }


    //Validation tests

    public function test_store_validate()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post('notes', [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['user_id', 'category_id', 'title', 'content']);
    }

    public function test_update_validate()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create([
           'user_id' => $user->id
        ]);

        $this
            ->actingAs($user)
            ->put("notes/$note->id", [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['user_id', 'category_id', 'title', 'content']);
    }

    //Policy tests

    public function test_show_policy()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create();

        $this
            ->actingAs($user)
            ->get("notes/$note->id")
            ->assertStatus(403);
    }

    public function test_edit_policy()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create();

        $this
            ->actingAs($user)
            ->get("notes/$note->id/edit")
            ->assertStatus(403);
    }

    public function test_update_policy()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $note = Note::factory()->create();

        $data = [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => $this->faker->title,
            'content' => $this->faker->text
        ];

        $this
            ->actingAs($user)
            ->put("notes/$note->id", $data)
            ->assertStatus(403);
    }

    public function test_delete_policy()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create();

        $this
            ->actingAs($user)
            ->delete("notes/$note->id")
            ->assertStatus(403);
    }
}
