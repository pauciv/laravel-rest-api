<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()//: Response
    {
        $categories = Category::all();
        return response()->json([
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)//: RedirectResponse
    {
        // return $request->all();

        $request->validate([
            'name' => ['required', 'string', 'unique:categories,name'],
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->save(); // save to db
        return response()->json([
            'category' => $category,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)//: Response
    {
        //$category = Category::findOrFail($category); // SELECT * FROM Categegories WHERE id = $id & if (is_null($category)) {abort(404);}
        return response()->json([
            "category" => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)//: RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:categories,name'],
        ]);
        // $category = $request;
        // $category->save(); // save to db
        // return response()->json([
        //     'category' => $category,
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)//: RedirectResponse
    {
        //
    }
}
