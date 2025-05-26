<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // GET /api/posts
    public function index()
    {
        return Post::all();
    }

    // GET /api/posts/{id}
    public function show($id)
    {
        return Post::findOrFail($id);
    }

    // POST /api/posts
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'views' => 'nullable|integer|min:0',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
        ]);

        $post = Post::create($validated);
        return response()->json($post, 201);
    }

    // PUT /api/posts/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'views' => 'nullable|integer|min:0',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
        ]);

        $post->update($validated);
        return response()->json($post);
    }

    // DELETE /api/posts/{id}
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
