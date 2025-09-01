@extends('layout.app')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                @if (isset($query) && $query)
                    <h2 class="fw-bolder mb-4">Search results for: "{{ $query }}"</h2>
                @else
                    <h2 class="fw-bolder mb-4">All Products</h2>
                @endif

                @if ($products->count() > 0)
                    <x-productsDisplay :products="$products" :wishlistBookIds="$wishlistBookIds" />
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-search" style="font-size: 4rem; color: #ccc;"></i>
                        <p class="text-muted fs-4 mt-3">No products found matching your search.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Back to All Products</a>
                    </div>
                @endif

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

