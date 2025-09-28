<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $transactions = Transaction::whereNotNull('rating')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.reviewsPage', compact('transactions'));
    }

    public function store(Request $request, Transaction $transaction)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->rating = $request->rating;
        $transaction->save();

        return redirect()->route('review')
            ->with('success', 'Review berhasil disimpan!');
    }
}
