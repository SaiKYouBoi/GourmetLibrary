<?php

namespace App\Http\Controllers;

use App\Models\Copy;
use Illuminate\Http\Request;

class CopyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'cookbook_id' => 'required|exists:cookbooks,id',
            'status' => 'required|string',
            'condition' => 'required|string'
        ]);

        $copy = Copy::create([
            'cookbook_id' => $request->cookbook_id,
            'status' => $request->status,
            'condition' => $request->condition
        ]);

        return response()->json($copy, 201);
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
        $copy = Copy::findOrFail($id);

        $request->validate([
            'status' => 'required|string',
            'condition' => 'required|string'
        ]);

        $copy->update([
            'status' => $request->status,
            'condition' => $request->condition
        ]);

        return response()->json([
            'message' => 'Copy updated successfully',
            'copy' => $copy
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $copy = Copy::findOrFail($id);

        $copy->delete();

        return response()->json([
            'message' => 'Copy deleted successfully'
        ]);
    }

    public function cookbookCopies($id)
    {
        $copies = Copy::where('cookbook_id', $id)->get();

        return response()->json($copies);
    }

    
}