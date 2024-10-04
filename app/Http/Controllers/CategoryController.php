<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function top()
    {
        $categories = Category::get();
        return view('admin.top', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return redirect()->route('admin.top');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $categoryId)
    {
        $category = Category::with('quizzes')->findOrFail($categoryId);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->delete();
        return redirect()->route('admin.top');
    }
}
