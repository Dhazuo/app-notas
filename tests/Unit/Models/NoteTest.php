<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_note_belongs_to()
    {
        $note = Note::factory()->create();

        $this->assertInstanceOf(Category::class, $note->category);
        $this->assertInstanceOf(User::class, $note->user);
    }
}
