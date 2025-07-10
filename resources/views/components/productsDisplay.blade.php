@props(['products', 'wishlistBookIds' => []])

<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content">
    @foreach ($products as $book)
        <div class="col mb-5">
            <div class="card h-100 text-dark">
                <a href="{{ route('product.detail', $book->id) }}" class="text-decoration-none">

                    <button class="btn btn-outline-danger btn-wishlist position-absolute"
                        style="top: 0.5rem; right: 0.5rem; z-index: 10;" data-book-id="{{ $book->id }}"
                        onclick="event.stopPropagation(); event.preventDefault();">
                        @php $isWished = in_array($book->id, $wishlistBookIds); @endphp
                        <i class="bi bi-heart{{ $isWished ? ' d-none' : '' }}"></i>
                        <i class="bi bi-heart-fill{{ !$isWished ? ' d-none' : '' }}"></i>
                    </button>

                    <img src="{{ asset('storage/covers/' . $book->cover) }}" alt="{{ $book->title }}" class="card-img-top"
                        style="height: 250px; object-fit: contain; background-color: #f8f9fa;">
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



@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.body.addEventListener('click', async function(event) {
                if (!event.target.matches('.btn-wishlist, .btn-wishlist *')) {
                    return;
                }

                const button = event.target.closest('.btn-wishlist');
                if (!button) return;

                event.preventDefault();

                const bookId = button.dataset.bookId;
                if (!bookId) {
                    console.error('Book ID not found!');
                    return;
                }

                const heartIcon = button.querySelector('.bi-heart');
                const heartFillIcon = button.querySelector('.bi-heart-fill');

                try {
                    const response = await fetch(`/wishlist/toggle/${bookId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();

                    if (data.status === 'added') {
                        heartIcon.classList.add('d-none');
                        heartFillIcon.classList.remove('d-none');
                    } else if (data.status === 'removed') {
                        heartIcon.classList.remove('d-none');
                        heartFillIcon.classList.add('d-none');
                    }

                } catch (error) {
                    console.error('There was a problem with the fetch operation:', error);
                }
            });
        });
    </script>
@endpush
