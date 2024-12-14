<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    // Get all answers
    public function index()
    {
        return response()->json(Answer::get());
    }

    // Get a single answer
    public function show($id)
    {
        $answer = Answer::find($id);
        if (!$answer) {
            return response()->json(['error' => 'Answer not found'], 404);
        }
        return response()->json($answer);
    }

    // Create a new answer
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'content' => 'required',
        ]);

        // Gunakan user yang sedang login
        $validated['user_id'] = Auth::id();

        $answer = Answer::create($validated);
        return response()->json($answer, 201);
    }

    // Update an answer
    public function update(Request $request, $id)
    {
        $answer = Answer::findOrFail($id);

        // Pastikan hanya pemilik yang bisa update
        if ($answer->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'content' => 'nullable',
        ]);

        $answer->update($validated);
        return response()->json($answer);
    }

    // Delete an answer
    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);

        // Pastikan hanya pemilik yang bisa hapus
        if ($answer->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $answer->delete();
        return response()->json(['message' => 'Answer deleted successfully']);
    }
}