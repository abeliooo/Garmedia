@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bolder">Detail Transaksi</h4>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali ke Daftar Transaksi</a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>
                <strong>ID Transaksi #{{ $transaction->id }}</strong>
            </span>
            <span>{{ $transaction->created_at->format('d F Y') }}</span>
        </div>
        <div class="card-body">
            <h5 class="card-title">Produk yang Dibeli</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" colspan="2">Produk</th>
                            <th scope="col" class="text-center">Jumlah</th>
                            <th scope="col" class="text-end">Harga Satuan</th>
                            <th scope="col" class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->products as $product)
                        <tr>
                            <td style="width: 70px;">
                                <img src="{{ asset('storage/covers/' . $product->cover) }}" alt="{{ $product->title }}"
                                    class="img-fluid rounded">
                            </td>
                            <td>
                                <strong>{{ $product->title }}</strong>
                                <br>
                                <small class="text-muted">{{ $product->author }}</small>
                            </td>
                            <td class="text-center align-middle">{{ $product->pivot->quantity }}</td>
                            <td class="text-end align-middle">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="text-end align-middle">
                                Rp {{ number_format($product->price * $product->pivot->quantity, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end border-0"><strong>Total Pembayaran</strong></td>
                            <td class="text-end border-0">
                                <strong>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Alamat Pengiriman</h5>
                    @if ($transaction->address)
                    <p class="card-text mb-0">{{ $transaction->address->recipient_name }}</p>
                    <p class="card-text mb-0">{{ $transaction->address->full_address }}</p>
                    <p class="card-text">{{ $transaction->address->city }}, {{ $transaction->address->postal_code }}</p>
                    @else
                    <p class="text-muted">Tidak ada alamat (Ambil di Toko)</p>
                    @endif
                </div>

                <div class="col-md-6">
                    <h5 class="card-title">Metode Pengiriman</h5>
                    <p class="card-text">{{ $transaction->shipping_method == 'courier' ? 'Kirim Garmedia' : 'Ambil di Toko' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection