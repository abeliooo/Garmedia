@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-5 mb-4 mb-lg-0">
            <div class="top" style="top: 2rem;">
                <img src="{{ asset($book->cover) }}" class="img-fluid rounded shadow-sm w-100" alt="Cover of {{ $book->title }}">
            </div>
        </div>

        <div class="col-lg-7">
            <h1 class="display-5 fw-bolder">{{ $book->title }}</h1>
            
            <a href="{{ route('search', ['search' => $book->author]) }}" class="lead text-muted text-decoration-none mb-3 d-block">{{ $book->author }}</a>

            <div class="fs-4 mb-3">
                <span>Rp {{ number_format($book->price, 0, ',', '.') }}</span>
            </div>

            <div id="description-short" class="text-muted small">
                {{ \Illuminate\Support\Str::words($book->description, 100, '...') }}
                @if (str_word_count($book->description) > 100)
                    <a href="#" id="btn-read-more" class="text-primary fw-bold text-decoration-none">Read more</a>
                @endif
            </div>
            <div id="description-full" class="text-muted small d-none">
                {{ $book->description }}
                <a href="#" id="btn-read-less" class="text-primary fw-bold text-decoration-none">Read less</a>
            </div>

            <hr class="my-4">

            <div class="mb-3">
                <label class="form-label fw-bold">Format:</label>
                <div class="btn-group" role="group">
                    @php
                        $isSoftCover = ($book->format == 'soft cover');
                        $isHardCover = ($book->format == 'hard cover');
                    @endphp

                    <input type="radio" class="btn-check" name="format" id="format-soft" autocomplete="off" {{ $isSoftCover ? 'checked' : '' }} disabled>
                    <label class="btn {{ $isSoftCover ? 'btn-primary' : 'btn-outline-secondary disabled' }}" for="format-soft">Soft Cover</label>

                    <input type="radio" class="btn-check" name="format" id="format-hard" autocomplete="off" {{ $isHardCover ? 'checked' : '' }} disabled>
                    <label class="btn {{ $isHardCover ? 'btn-primary' : 'btn-outline-secondary disabled' }}" for="format-hard">Hard Cover</label>
                </div>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="input-group me-3" style="max-width: 120px;">
                    <button class="btn btn-outline-secondary" type="button" id="button-minus">-</button>
                    <input type="text" class="form-control text-center" id="inputQuantity" value="1" readonly>
                    <button class="btn btn-outline-secondary" type="button" id="button-plus">+</button>
                </div>
                <button class="btn btn-dark flex-shrink-0" type="button">
                    <i class="bi-cart-fill me-1"></i>
                    Add to cart
                </button>
            </div>

            <hr class="my-4">

            <div>
                <h5 class="fw-bold mb-3">Book Details</h5>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Publisher:</strong><br>{{ $book->publisher }}</li>
                            <li class="mb-2"><strong>ISBN:</strong><br>{{ $book->isbn }}</li>
                            <li class="mb-2"><strong>Language:</strong><br>{{ $book->language }}</li>
                            <li class="mb-2"><strong>Release Date:</strong><br>{{ $book->release_date->format('d F Y') }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Length:</strong><br>{{ $book->length }} cm</li>
                            <li class="mb-2"><strong>Width:</strong><br>{{ $book->width }} cm</li>
                            <li class="mb-2"><strong>Weight:</strong><br>{{ $book->weight }} g</li>
                            <li class="mb-2"><strong>Pages:</strong><br>{{ $book->page }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Logika untuk tombol kuantitas
    const btnMinus = document.getElementById('button-minus');
    const btnPlus = document.getElementById('button-plus');
    const inputQuantity = document.getElementById('inputQuantity');

    btnMinus.addEventListener('click', function () {
        let currentValue = parseInt(inputQuantity.value);
        if (currentValue > 1) {
            inputQuantity.value = currentValue - 1;
        }
    });

    btnPlus.addEventListener('click', function () {
        let currentValue = parseInt(inputQuantity.value);
        inputQuantity.value = currentValue + 1;
    });

    const btnReadMore = document.getElementById('btn-read-more');
    const btnReadLess = document.getElementById('btn-read-less');
    const shortDesc = document.getElementById('description-short');
    const fullDesc = document.getElementById('description-full');

    if (btnReadMore) {
        btnReadMore.addEventListener('click', function (e) {
            e.preventDefault();
            shortDesc.classList.add('d-none');
            fullDesc.classList.remove('d-none');
        });
    }

    if (btnReadLess) {
        btnReadLess.addEventListener('click', function (e) {
            e.preventDefault();
            fullDesc.classList.add('d-none');
            shortDesc.classList.remove('d-none');
        });
    }
});
</script>
@endpush
