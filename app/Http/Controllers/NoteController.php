<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $notes = Note::where('user_id', $id)->latest()->get();

        return Inertia::render('NotesPages/Index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('NotesPages/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoteRequest $request)
    {
        $note = Note::create([
            'user_id' => auth()->user()->id,
            'category_id' => $request->get('category_id'),
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'color_blue' => $request->boolean('color_blue'),
            'color_yellow' => $request->boolean('color_yellow'),
            'color_pink' => $request->boolean('color_pink'),
        ]);

        return response()->json([], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        $this->authorize('pass', $note);

        return Inertia::render('NotesPages/Show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        $this->authorize('pass', $note);

        return Inertia::render('NotesPages/Edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(NoteRequest $request, Note $note)
    {
        $this->authorize('pass', $note);

        $note->update($request->all());
        return response()->json([],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $this->authorize('pass', $note);

        $note->delete();
        return response()->json([
            'message' => 'Deleted successfully'
        ], 200);
    }
}
