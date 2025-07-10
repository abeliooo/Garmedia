@extends('layout.app')

@section('content')
<div class="container my-5">
    <h1 class="fw-bolder mb-4">My Wishlist</h1>

    @if($products->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-heart" style="font-size: 4rem; color: #ccc;"></i>
            <p class="text-muted fs-4 mt-3">Your wishlist is empty.</p>
            <p class="text-muted">Click the heart icon on any product to add it here.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Explore Books</a>
        </div>
    @else
        <x-productsDisplay :products="$products" :wishlistBookIds="$wishlistBookIds" />
    @endif
</div>
@endsection