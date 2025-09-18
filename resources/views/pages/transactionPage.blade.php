@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Checkout Berhasil!</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <p>Terima kasih telah berbelanja. Pesanan Anda sedang kami proses.</p>

                    <h5 class="mt-4">Detail Transaksi</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>ID Transaksi:</strong>
                            <span>#{{ $transaction->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Total Pembayaran:</strong>
                            <span class="fw-bold text-danger">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Metode Pengiriman:</strong>
                            <span>{{ $transaction->shipping_method == 'courier' ? 'Kurir Garmedia' : 'Ambil di Tempat' }}</span>
                        </li>
                        @if($transaction->address)
                        <li class="list-group-item">
                            <strong>Dikirim ke:</strong><br>
                            {{ $transaction->address->recipient_name }}<br>
                            {{ $transaction->address->full_address }}
                        </li>
                        @endif
                    </ul>

                    <h5 class="mt-4">Rincian Produk</h5>
                    <table class="table">
                        <tbody>
                            @foreach($transaction->products as $product)
                            <tr>
                                <td>{{ $product->title }} (x{{ $product->pivot->quantity }})</td>
                                <td class="text-end">Rp {{ number_format($product->pivot->price * $product->pivot->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="fw-bold">Biaya Kirim</td>
                                <td class="text-end fw-bold">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Kembali Berbelanja</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection