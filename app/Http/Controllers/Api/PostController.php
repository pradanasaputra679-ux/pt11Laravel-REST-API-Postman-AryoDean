<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    // Menampilkan semua data post
    public function index()
    {
        $posts = Post::latest()->get();

        return PostResource::collection($posts);
    }

    // Menambahkan data post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post = Post::create($validated);

        return new PostResource($post);
    }

    // Menampilkan satu data post
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    // Memperbarui data post
    public function update(Request $request, Post $post)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ];

        if ($request->isMethod('patch')) {
            $rules = [
                'title' => 'sometimes|required|string|max:255',
                'body' => 'sometimes|required|string',
            ];
        }

        $validated = $request->validate($rules);

        $post->update($validated);

        return new PostResource($post);
    }

    // Menghapus data post
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'message' => 'Data post berhasil dihapus'
        ]);
    }
}
