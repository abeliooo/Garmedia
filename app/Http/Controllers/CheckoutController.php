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
        $cartItems = $user->cartItems; // Menggunakan relasi cartItems dari model User
        $addresses = $user->addresses; // Menggunakan relasi addresses dari model User

        // Jika keranjang kosong, kembalikan ke halaman keranjang
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Hitung subtotal untuk ditampilkan di view
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->pivot->quantity;
        });

        // Kirim semua data yang dibutuhkan ke view checkoutPage
        return view('pages.checkoutPage', compact('cartItems', 'addresses', 'subtotal'));
    }

    /**
     * Memproses pesanan, membuat transaksi, dan mengosongkan keranjang.
     */
    public function process(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'shipping_method' => 'required|string|in:pickup,courier',
            // Alamat wajib dipilih jika metode pengiriman adalah kurir
            'address_id' => 'required_if:shipping_method,courier|exists:addresses,id',
        ]);

        $user = Auth::user();
        $cartItems = $user->cartItems;

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Cannot process an empty cart.');
        }

        // Menggunakan DB Transaction untuk memastikan semua query berhasil atau tidak sama sekali
        try {
            DB::beginTransaction();

            // 2. Hitung total biaya
            $subtotal = $cartItems->sum(fn($item) => $item->price * $item->pivot->quantity);
            $shippingCost = $request->shipping_method == 'courier' ? 6500 : 0;
            $totalAmount = $subtotal + $shippingCost;

            // 3. Buat record transaksi baru
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'address_id' => $request->shipping_method == 'courier' ? $request->address_id : null,
                'total_amount' => $totalAmount,
                'shipping_method' => $request->shipping_method,
                'shipping_cost' => $shippingCost,
                'status' => 'pending', // Status awal pesanan
            ]);

            // 4. Pindahkan item dari keranjang ke detail transaksi (pivot table)
            foreach ($cartItems as $item) {
                $transaction->products()->attach($item->id, [
                    'quantity' => $item->pivot->quantity,
                    'price' => $item->price // Simpan harga saat checkout
                ]);
            }

            // 5. Kosongkan keranjang pengguna
            $user->cartItems()->detach();

            DB::commit();

            // 6. Arahkan ke halaman sukses dengan membawa ID transaksi
            return redirect()->route('transaction.show', $transaction->id)
                ->with('success', 'Checkout successful! Your order is being processed.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Jika terjadi error, kembalikan ke halaman checkout dengan pesan error
            return redirect()->route('checkout.index')->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }
}
