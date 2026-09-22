<?php

namespace App\Http\Controllers;

use App\Models\ViewingHistory;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = ViewingHistory::with('article.user')
        ->where('user_id', Auth::id())
        ->whereHas('article')
        ->latest('viewed_at')
        ->paginate(20);

        return view('histories.index', compact('histories'));

    }
}