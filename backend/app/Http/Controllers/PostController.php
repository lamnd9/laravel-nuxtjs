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
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        return Post::create($request->only('title', 'content'));
    }

    // PUT /api/posts/{id}
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);

        $post->update($request->only('title', 'content'));

        return $post;
    }

    // DELETE /api/posts/{id}
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
