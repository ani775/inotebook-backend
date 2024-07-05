<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function addNote(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'tag' => 'nullable|string|max:50',
        //     'date' => 'required|date',
        // ]);

        $user_id = Auth::id();

        DB::table('notes')->insert([
            'user_id' => $user_id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'tag' => $request->input('tag'),
            'date' => now(),
            //'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Note added successfully'], 201);
    }

    public function fetchNotes(Request $request)
    {

        $user_id = Auth::id();

        $notes = DB::table('notes')->where('user_id',$user_id)->get();

        return response()->json($notes, 200);
    }

    public function updateNote(Request $request, $id)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'tag' => 'nullable|string|max:50',
        //     'date' => 'required|date',
        // ]);

        $user_id = Auth::id();

        $note = DB::table('notes')
                    ->where('id', $id)
                    ->where('user_id', $user_id)
                    ->first();

        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        DB::table('notes')
            ->where('id', $id)
            ->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'tag' => $request->input('tag'),
                //'date' => $request->input('date'),
                'date' => now(),
            ]);

        return response()->json(['message' => 'Note updated successfully'], 200);
    }

    public function deleteNote(Request $request, $id)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'tag' => 'nullable|string|max:50',
        //     'date' => 'required|date',
        // ]);

        $user_id = Auth::id();

        $note = DB::table('notes')
                    ->where('id', $id)
                    ->where('user_id', $user_id)
                    ->first();

        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        DB::table('notes')
            ->where('id', $id)->delete();

        return response()->json(['message' => 'Note deleted successfully'], 200);
    }
}
