@extends('layout.app')

@section('content')
<div class="container my-5">
    <h1 class="fw-bolder mb-4">Shopping Cart</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($cartItems->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-cart3" style="font-size: 4rem; color: #ccc;"></i>
            <p class="text-muted fs-4 mt-3">Your cart is empty.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Continue Shopping</a>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8">
                @foreach($cartItems as $item)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center">
                                <div>
                                    <img src="{{ asset('storage/covers/' . $item->cover) }}" class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-1">{{ $item->title }}</h5>
                                    <p class="small mb-0">{{ $item->author }}</p>
                                </div>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                                <div style="width: 80px;">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex">
                                        @csrf
                                        <input type="number" name="quantity" min="1" value="{{ $item->pivot->quantity }}" class="form-control form-control-sm text-center me-2" onchange="this.form.submit()">
                                    </form>
                                </div>
                                <div style="width: 100px;">
                                    <h5 class="mb-0">Rp {{ number_format($item->price * $item->pivot->quantity, 0, ',', '.') }}</h5>
                                </div>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-danger" style="padding: 0;"><i class="bi bi-trash-fill"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Order Summary</h5>
                        @php
                            $subtotal = $cartItems->sum(function($item) {
                                return $item->price * $item->pivot->quantity;
                            });
                        @endphp
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-dark w-100 mt-4">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
