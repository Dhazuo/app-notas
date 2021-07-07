<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NoteCategoryController extends Controller
{
    public function category_index()
    {
        $id = Auth::id();

        $notes = Note::where('user_id', $id)->latest()->get();
        return Inertia::render('NotesPages/CategoryIndex', compact( 'notes'));
    }
}
