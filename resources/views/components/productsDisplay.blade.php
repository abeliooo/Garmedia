@props(['products'])
<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

    @foreach ($products as $product)
        <div class="col mb-5">
            <div class="card h-100">

                <a href="#" class="btn btn-outline-danger btn-wishlist position-absolute"
                    style="top: 0.5rem; right: 0.5rem">
                    <i class="bi bi-heart"></i>
                    <i class="bi bi-heart-fill d-none"></i>
                </a>

                <img class="card-img-top" src="{{ $product['image'] }}" alt="{{ $product['title'] }}">

                <div class="card-body p-4">
                    <div class="text-start">
                        <h5 class="fw-bolder">{{ $product['title'] }}</h5>
                        <p class="text-muted mb-2">{{ $product['author'] }}</p>
                        Rp {{ number_format($product['price'], 0, ',', '.') }}
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
