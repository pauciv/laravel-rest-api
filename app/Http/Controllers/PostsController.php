<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Category;
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
        // hace el load('category') que hacemos en el show pero en todos los posts.
        $posts = Post::with('category')->get(); // $posts = Post::all();
        return response()->json([
            "posts" => $posts,
        ]);
    }

    public function postsByCategory(Category $category)
    {
        // $posts = Post::where('category_id', $category->id)
        //     ->orderBy('published_at', 'DESC') // orderByDesc
        //     ->get();
        // return $posts;

        //! con relaciones de eloquent (definimos la relación dentro del modelo y lo podemos llamar)
        // return $category->posts()->get(); // laravel lo ejecuta por nosotros
        return response()->json([
            "posts" => $category->posts,
        ]);

        // return $category->posts()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)//: RedirectResponse
    {
        $validated = $request->validated();

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
        $post->load('category');
        return response()->json([
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)//: RedirectResponse
    {
        // si vamos a hacer patch, los campos no van a ser obligatorios mientras que si hacemos put sí.
        // sometimes significa que si no está, no pasa nada, y si sí que está, lo va a validar con el resto de reglas.
        $validated = $request->validated();

        // dd($validated); // console.log
        $post->update($validated);
        return response()->json([
            'post' => $post,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)//: RedirectResponse
    {
        $post->delete();
        return response()->json([
            "success" => true,
        ]);
    }
}
