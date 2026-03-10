<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Copy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(1);

        if ($user->role === 'admin') {
            $borrows = Borrow::with(['user', 'copy.cookbook'])->get();
        } else {
            $borrows = Borrow::with('copy.cookbook')
                ->where('user_id', $user->id)
                ->get();
        }

        return response()->json($borrows);
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
            'copy_id' => 'required|exists:copies,id'
        ]);

        $copy = Copy::findOrFail($request->copy_id);

        if ($copy->status === 'borrowed') {
            return response()->json([
                'message' => 'This copy is already borrowed'
            ], 400);
        }

        $borrow = Borrow::create([
            'user_id' => Auth::id(),
            'copy_id' => $copy->id,
            'borrow_date' => now()
        ]);

        $copy->update(['status' => 'borrowed']);

        return response()->json($borrow, 201);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function returnBook($id)
    {
        $borrow = Borrow::findOrFail($id);

        if ($borrow->return_date) {
            return response()->json([
                'message' => 'This copy has already been returned'
            ], 400);
        }

        $borrow->update([
            'return_date' => now()
        ]);

        $borrow->copy->update(['status' => 'available']);

        return response()->json([
            'message' => 'Book returned successfully',
            'borrow' => $borrow
        ]);
    }

}