@props(['books', 'wishlistBookIds' => []])

<div class="carousel-container position-relative">
    {{-- Pastikan class ini 'carousel' agar cocok dengan JS --}}
    <div class="carousel">
        @foreach ($books as $book)
            <div class="book-card-wrapper">
                <div class="card h-100 text-dark">
                    <button class="btn btn-outline-danger btn-wishlist position-absolute"
                        style="top: 0.5rem; right: 0.5rem; z-index: 10;" data-book-id="{{ $book->id }}">
                        @php $isWished = in_array($book->id, $wishlistBookIds); @endphp
                        <i class="bi bi-heart{{ $isWished ? ' d-none' : '' }}"></i>
                        <i class="bi bi-heart-fill{{ !$isWished ? ' d-none' : '' }}"></i>
                    </button>

                    <a href="{{ route('product.detail', $book->id) }}" class="text-decoration-none">
                        <img src="{{ asset('storage/covers/' . $book->cover) }}" alt="{{ $book->title }}"
                            class="card-img-top" style="height: 250px; object-fit: contain; background-color: #f8f9fa;">
                    </a>
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div class="text-start mb-3">
                            <h5 class="fw-bolder">{{ $book->title }}</h5>
                            <p class="text-muted mb-2">{{ $book->author }}</p>
                            <strong>Rp {{ number_format($book->price, 0, ',', '.') }}</strong>
                        </div>
                        <div class="text-center mt-auto">
                            <a class="btn btn-outline-dark w-100" href="#">Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button class="carousel-arrow prev-arrow btn btn-light shadow-sm">&lsaquo;</button>
    <button class="carousel-arrow next-arrow btn btn-light shadow-sm">&rsaquo;</button>
</div>