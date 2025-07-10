@extends('layout.app')

@section('content')
    <div class="container my-5">
        @if (isset($searchTerm) && $searchTerm != '')
            <h1 class="fw-bolder mb-4">Search Result For: "{{ $searchTerm }}"</h1>
        @else
            <h1 class="fw-bolder mb-4">All Related Product</h1>
        @endif

        @if ($products->isEmpty())
            <div class="text-center py-5">
                @if (isset($searchTerm) && $searchTerm != '')
                    <p class="text-muted fs-4">There's No Product Related To Your Search"{{ $searchTerm }}"</p>
                @else
                    <p class="text-muted fs-4">Product Is Not Available</p>
                @endif
            </div>
        @else
            <x-productsDisplay :products="$products" :wishlistBookIds="$wishlistBookIds" />
        @endif
    </div>
@endsection
