@extends('layout.app')

@section('content')
<div class="container my-5">
    <h3>Review Saya</h3>

    @forelse($transactions as $transaction)
        <div class="card mb-3">
            <div class="card-body">
                <h5>ID Transaksi #{{ $transaction->id }}</h5>
                <p><strong>Total:</strong> Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                <p>
                    <strong>Rating:</strong>
                    @for($i=1; $i<=5; $i++)
                        <span class="{{ $i <= $transaction->rating ? 'text-warning' : 'text-secondary' }}">★</span>
                    @endfor
                </p>
            </div>
        </div>
    @empty
        <p>Belum ada review.</p>
    @endforelse
</div>
@endsection
