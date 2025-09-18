<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function show(Transaction $transaction)
    {
        if (Auth::id() !== $transaction->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->load('products', 'address');

        return view('transaction', compact('transaction'));
    }
}
