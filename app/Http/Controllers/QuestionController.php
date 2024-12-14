<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Get all questions
    public function index(Request $request)
    {
       return response()->json(Question::all(),200);
    }

    // Get a single question
    public function show($id)
    {
        $question = Question::with(['user','topic','answers.user'])->find($id);
        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }
        return response()->json($question);
    }

    // Create a new question
    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Gunakan user yang sedang login
        $validated['user_id'] = auth()->id();

        $question = Question::create($validated);
        return response()->json($question, 201);
    }

    // Update a question
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        
        // Pastikan hanya pemilik yang bisa update
        if ($question->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'nullable|max:255',
            'content' => 'nullable',
            'topic_id' => 'exists:topics,id',
        ]);

        $question->update($validated);
        return response()->json($question);
    }

    // Destroy a question
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        
        // Pastikan hanya pemilik yang bisa hapus
        if ($question->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $question->delete();
        return response()->json(['message' => 'Question deleted successfully']);
    }
}
