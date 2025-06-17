<?php

namespace App\Http\Controllers\Incomingbooks;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\IncomingBooks\IncomingBooks;

class IncomingbooksController extends Controller
{
    public function index()
    {
        return view('content.Incomingbooks.index');
    }

    /* public function getKeywordSuggestions(Request $request)
    {
        $search = trim($request->input('keyword'));

        if (!$search || strlen($search) < 2) {
            return response()->json([]);
        }

        $keywords = DB::table('incomingbooks')
            ->whereNotNull('keywords')
            ->select('keywords')
            ->get();

        $suggestions = collect();

        foreach ($keywords as $item) {
            $tags = explode(',', $item->keywords);
            foreach ($tags as $tag) {
                $tag = trim($tag);
                if (!empty($tag) && stripos($tag, $search) !== false) {
                    $suggestions->push($tag);
                }
            }
        }

        $suggestions = $suggestions
            ->unique()
            ->map(function ($tag) {
                return ['value' => $tag];
            })
            ->values()
            ->take(10);

        return response()->json($suggestions);
    } */

    public function getKeywordSuggestions(Request $request)
{
    $search = trim($request->input('keyword'));

    if (!$search || strlen($search) < 2) {
        return response()->json([]);
    }

    $keywords = DB::table('incomingbooks')
        ->whereNotNull('keywords')
        ->select('keywords')
        ->get();

    $suggestions = collect();

    foreach ($keywords as $item) {
        $tags = explode(',', $item->keywords);
        foreach ($tags as $tag) {
            $tag = trim($tag);
            if (!empty($tag) && stripos($tag, $search) !== false) {
                $suggestions->push($tag);
            }
        }
    }

    $suggestions = $suggestions
        ->unique()
        ->map(function ($tag) {
            return ['value' => $tag];
        })
        ->values()
        ->take(10);

    return response()->json($suggestions);
}
}
