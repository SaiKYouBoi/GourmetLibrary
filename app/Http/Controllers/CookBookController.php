<?php

namespace App\Http\Controllers;

use App\Models\CookBook;
use Illuminate\Http\Request;

class CookBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cookbooks = Cookbook::with('category')->get();

        return response()->json($cookbooks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'chef' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        $cookbook = CookBook::create([
            'title' => $request->title,
            'chef' => $request->chef,
            'description' => $request->description,
            'category_id' => $request->category_id
        ]);

        return response()->json([
            'message' => 'Cookbook created successfully',
            'cookbook' => $cookbook
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cookbook = Cookbook::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'chef' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        $cookbook->update([
            'title' => $request->title,
            'chef' => $request->chef,
            'description' => $request->description,
            'category_id' => $request->category_id
        ]);

        return response()->json([
            'message' => 'Cookbook updated successfully',
            'cookbook' => $cookbook
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cookbook = Cookbook::findOrFail($id);

        $cookbook->delete();

        return response()->json([
            'message' => 'Cookbook deleted successfully'
        ]);
    }

    public function byCategory($categoryId)
    {
        $cookbooks = Cookbook::where('category_id', $categoryId)->get();

        return response()->json($cookbooks);
    }

    public function search(Request $request)
    {
        $input = $request->input;

        $cookbooks = Cookbook::where('title', 'like', "%$input%")
            ->orWhere('chef', 'like', "%$input%")
            ->orWhereHas('category', function ($query) use ($input) {
                $query->where('name', 'like', "%$input%");
            })
            ->get();

        return response()->json($cookbooks);
    }

    public function mostPopular($categoryId)
    {
        $cookbooks = Cookbook::withCount([
            'copies as borrow_count' => function ($query) {
                $query->join('borrows', 'copies.id', '=', 'borrows.copy_id');
            }
        ])
            ->where('category_id', $categoryId)
            ->orderByDesc('borrow_count')
            ->take(5)
            ->get();

        return response()->json($cookbooks);
    }

    public function newArrivals($categoryId)
    {
        $cookbooks = Cookbook::where('category_id', $categoryId)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return response()->json($cookbooks);
    }
}
