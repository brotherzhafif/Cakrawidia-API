<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Get all likes
    public function index()
    {
        return response()->json(Like::all());
    }

    // Get likes for a specific entity
    public function getLikesByEntity($entityType, $entityId)
    {
        $likes = Like::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->get();

        return response()->json($likes);
    }

    // Create a new like
    public function store(Request $request)
    {
        $validated = $request->validate([
            'entity_type' => 'required|in:question,answer',
            'entity_id' => 'required|integer',
        ]);

        // Gunakan user yang sedang login
        $validated['user_id'] = auth()->id();

        // Validasi entitas
        if ($validated['entity_type'] === 'question') {
            if (!Question::find($validated['entity_id'])) {
                return response()->json(['error' => 'Question not found'], 404);
            }
        } elseif ($validated['entity_type'] === 'answer') {
            if (!Answer::find($validated['entity_id'])) {
                return response()->json(['error' => 'Answer not found'], 404);
            }
        }

        // Cek apakah user sudah pernah like sebelumnya
        $existingLike = Like::where('user_id', $validated['user_id'])
            ->where('entity_type', $validated['entity_type'])
            ->where('entity_id', $validated['entity_id'])
            ->first();

        if ($existingLike) {
            return response()->json(['error' => 'You have already liked this'], 400);
        }

        $like = Like::create($validated);
        return response()->json($like, 201);
    }

    // Delete a like
    public function destroy($id)
    {
        $like = Like::findOrFail($id);
        
        // Pastikan hanya pemilik yang bisa hapus like
        if ($like->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $like->delete();
        return response()->json(['message' => 'Like deleted successfully']);
    }
}
