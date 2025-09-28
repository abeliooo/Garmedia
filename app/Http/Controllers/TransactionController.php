<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $transactions = Transaction::where('user_id', $user->id)->with('products')->latest()->paginate(10);

        return view('pages.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        if (Auth::id() !== $transaction->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->load('products', 'address');

        return view('pages.transactions.show', compact('transaction'));
    }
}
