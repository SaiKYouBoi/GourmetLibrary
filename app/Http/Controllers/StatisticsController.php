<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CookBook;
use App\Models\Copy;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {

        $mostConsultedBooks = CookBook::withCount([
            'copies as borrows_count' => function ($query) {
                $query->join('borrows', 'copies.id', '=', 'borrows.copy_id');
            }
        ])
            ->orderByDesc('borrows_count')
            ->take(5)
            ->get(['id', 'title', 'chef']);

        $collectionCondition = Copy::select('condition')
            ->selectRaw('count(*) as total')
            ->groupBy('condition')
            ->get();

        $mostRepresentedCategories = Category::withCount('cookbooks')
            ->orderByDesc('cookbooks_count')
            ->take(5)
            ->get(['id', 'name', 'cookbooks_count']);

        return response()->json([
            'most_consulted_books' => $mostConsultedBooks,
            'collection_condition' => $collectionCondition,
            'most_represented_categories' => $mostRepresentedCategories
        ]);
    }

    public function degradedBooks()
    {
        $books = Cookbook::withCount([
            'copies as degraded_count' => function ($query) {
                $query->whereIn('condition', ['damaged', 'stained']); // conditions considered degraded
            }
        ])->get(['id', 'title', 'chef']);

        return response()->json($books);
    }
}
