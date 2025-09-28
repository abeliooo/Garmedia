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
                    <strong>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong>
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
            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-primary">Lihat Detail</a>

            @if(is_null($transaction->rating))
            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $transaction->id }}">
                Review
            </button>
            @else
            <span class="badge bg-success">Sudah Review</span>
            @endif
        </div>
    </div>

    <div class="modal fade" id="reviewModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="reviewModalLabel{{ $transaction->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('transactions.review', $transaction->id) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel{{ $transaction->id }}">Beri Review Transaksi #{{ $transaction->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="rating d-flex justify-content-center flex-row-reverse">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio"
                                    id="star{{ $i }}-{{ $transaction->id }}"
                                    name="rating"
                                    value="{{ $i }}"
                                    class="d-none">
                                <label for="star{{ $i }}-{{ $transaction->id }}"
                                    style="font-size:2rem; cursor:pointer; color: #ccc;">★</label>
                            @endfor
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
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

<!-- CSS interaksi bintang -->
<style>
.rating label:hover,
.rating label:hover ~ label,
.rating input:checked ~ label {
    color: gold !important;
}
</style>
@endsection
