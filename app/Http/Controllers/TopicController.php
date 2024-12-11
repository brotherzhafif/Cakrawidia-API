<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    // Get all topics
    public function index()
    {
        return response()->json(Topic::all());
    }

    // Get a single topic
    public function show($id)
    {
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json(['error' => 'Topic not found'], 404);
        }
        return response()->json($topic);
    }

    // Create a new topic
    public function store(Request $request)
    {
        // Cek apakah user adalah admin
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|unique:topics,name|max:255',
        ]);

        $topic = Topic::create($validated);
        return response()->json($topic, 201);
    }

    // Update a topic
    public function update(Request $request, $id)
    {
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json(['error' => 'Topic not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|unique:topics,name|max:255',
        ]);

        $topic->update($validated);
        return response()->json($topic);
    }

    // Delete a topic
    public function destroy($id)
    {
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json(['error' => 'Topic not found'], 404);
        }

        $topic->delete();
        return response()->json(['message' => 'Topic deleted successfully']);
    }
}
