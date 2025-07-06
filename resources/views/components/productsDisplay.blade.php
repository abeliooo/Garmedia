@props(['products'])
<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content">
    @foreach ($products as $book)
        <div class="col mb-5">
            <div class="card h-100 position-relative" onclick="window.location='{{ route('product.detail', $book->id) }}'">
                <button class="btn btn-outline-danger btn-wishlist position-absolute"
                        style="top: 0.5rem; right: 0.5rem; z-index: 10;"
                        onclick="event.stopPropagation();">
                    <i class="bi bi-heart"></i>
                    <i class="bi bi-heart-fill d-none"></i>
                </button>

                <img src="{{ asset($book->cover) }}" class="card-img-top" alt="{{ $book->title }}">

                <div class="card-body p-4">
                    <div class="text-start">
                        <h5 class="fw-bolder">{{ $book->title }}</h5>
                        <p class="text-muted mb-2">{{ $book->author }}</p>
                        <strong>Rp {{ number_format($book->price, 0, ',', '.') }}</strong>
                    </div>
                </div>

                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center">
                        <a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wishlistButtons = document.querySelectorAll('.btn-wishlist');

            wishlistButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const heartIcon = button.querySelector('.bi-heart');
                    const heartFillIcon = button.querySelector('.bi-heart-fill');

                    heartIcon.classList.toggle('d-none');
                    heartFillIcon.classList.toggle('d-none');
                });
            });
        });
    </script>
@endpush
