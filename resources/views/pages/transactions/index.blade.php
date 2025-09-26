@extends('layout.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">My Transactions</h1>

    @forelse ($transactions as $transaction)
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between flex-wrap">
            <span class="fw-bold">
                ID Transaksi #{{ $transaction->id }}
            </span>
            <span class="text-muted">
                {{ $transaction->created_at->format('d F Y') }}
            </span>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total Pembayaran</span>
                    <strong>Rp {{ number_format($transaction->total, 0, ',', '.') }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Metode Pengiriman</span>
                    <strong>{{ $transaction->shipping_method == 'courier' ? 'Kirim Garmedia' : 'Ambil di Toko' }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Status</span>
                    <p class="mb-0">
                        @if ($transaction->status === 'finished')
                        <span class="badge bg-primary">Finished</span>
                        @elseif ($transaction->status === 'pending')
                        <span class="badge bg-success">Pending</span>
                        @else
                        <span class="badge bg-secondary">{{ ucfirst($transaction->status) }}</span>
                        @endif
                    </p>

                </li>
            </ul>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-primary btn-sm">
                Lihat Detail
            </a>
        </div>
    </div>
    @empty
    <div class="alert alert-info text-center">
        Anda belum memiliki riwayat transaksi.
    </div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection