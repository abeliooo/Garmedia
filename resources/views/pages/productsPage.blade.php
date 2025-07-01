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
                {{-- Cek lagi apakah ini konteks pencarian atau bukan --}}
                @if (isset($searchTerm) && $searchTerm != '')
                    <p class="text-muted fs-4">Oops, tidak ada produk yang cocok dengan pencarian "{{ $searchTerm }}"</p>
                @else
                    <p class="text-muted fs-4">Saat ini belum ada produk yang tersedia.</p>
                @endif
            </div>
        @else
            <x-productsDisplay :products="$products" />
        @endif
    </div>
@endsection
