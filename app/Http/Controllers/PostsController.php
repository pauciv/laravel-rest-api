<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()//: Response
    {
        $posts = Post::all();
        return response()->json([
            "posts" => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)//: RedirectResponse
    {
        $validated = $request->validate([
            "title" => ['required', 'string', 'min:8'],
            "content" => ['required', 'string', 'min:100'],
            "published_at" => ['required', 'date'],
            "category_id" => ['required', 'exists:categories,id'],
        ]);

        $post = Post::create($validated);
        return response()->json([
            'post' => $post,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)//: Response
    {
        return response()->json([
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)//: RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)//: RedirectResponse
    {
        //
    }
}
