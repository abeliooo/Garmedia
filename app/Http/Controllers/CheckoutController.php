<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems;
        $addresses = $user->addresses;

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->pivot->quantity;
        });

        return view('pages.checkoutPage', compact('cartItems', 'addresses', 'subtotal'));
    }

    /**
     * Memproses pesanan, membuat transaksi, dan mengosongkan keranjang.
     */
    public function process(Request $request)
    {
        $request->validate([
            'shipping_method' => 'required|string|in:pickup,courier',
            'address_id' => 'required_if:shipping_method,courier|exists:addresses,id',
        ]);

        $user = Auth::user();
        $cartItems = $user->cartItems;

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Cannot process an empty cart.');
        }

        try {
            DB::beginTransaction();

            $subtotal = $cartItems->sum(fn($item) => $item->price * $item->pivot->quantity);
            $shippingCost = $request->shipping_method == 'courier' ? 6500 : 0;
            $totalAmount = $subtotal + $shippingCost;

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'address_id' => $request->shipping_method == 'courier' ? $request->address_id : null,
                'total_amount' => $totalAmount,
                'shipping_method' => $request->shipping_method,
                'shipping_cost' => $shippingCost,
                'status' => 'pending', 
            ]);

            foreach ($cartItems as $item) {
                $transaction->products()->attach($item->id, [
                    'quantity' => $item->pivot->quantity,
                    'price' => $item->price 
                ]);
            }

            $user->cartItems()->detach();

            DB::commit();

            return redirect()->route('transactions.index', $transaction->id)
                ->with('success', 'Checkout successful! Your order is being processed.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }
}
