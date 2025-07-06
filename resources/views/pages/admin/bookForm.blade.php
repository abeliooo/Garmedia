@extends('layout.guest')

@section('content')
    <div class="container my-5">
        <h1 class="fw-bolder mb-4">{{ isset($book) ? 'Edit Book' : 'Add New Book' }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <h5 class="alert-heading">There were some problems with your input.</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form id="book-form" action="{{ isset($book) ? route('admin.books.update', $book->id) : route('admin.books.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($book))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $book->title ?? '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control" id="author" name="author"
                                    value="{{ old('author', $book->author ?? '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $book->description ?? '') }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="publisher" class="form-label">Publisher</label>
                                    <input type="text" class="form-control" id="publisher" name="publisher"
                                        value="{{ old('publisher', $book->publisher ?? '') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="text" class="form-control" id="isbn" name="isbn"
                                        value="{{ old('isbn', $book->isbn ?? '') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="image" class="form-label">Book Cover</label>
                                <div class="cover-preview-wrapper">
                                    <img id="cover-preview"
                                        src="{{ isset($book) && $book->cover ? asset($book->cover) : 'https://placehold.co/300x400/dee2e6/6c757d?text=Cover' }}"
                                        alt="Cover Preview">
                                </div>
                                <input type="file" class="form-control mt-2" id="image" name="image"
                                    onchange="previewCover()">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Format</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="formats[]" value="soft cover"
                                        id="format-soft" @if (is_array(old('formats', $book->formats ?? [])) && in_array('soft cover', old('formats', $book->formats ?? []))) checked @endif>
                                    <label class="form-check-label" for="format-soft">Soft Cover</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="formats[]" value="hard cover"
                                        id="format-hard" @if (is_array(old('formats', $book->formats ?? [])) && in_array('hard cover', old('formats', $book->formats ?? []))) checked @endif>
                                    <label class="form-check-label" for="format-hard">Hard Cover</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price (Rp)</label>
                                <input type="number" class="form-control" id="price" name="price"
                                    value="{{ old('price', $book->price ?? '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="language" class="form-label">Language</label>
                                <input type="text" class="form-control" id="language" name="language"
                                    value="{{ old('language', $book->language ?? '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="release_date" class="form-label">Release Date</label>
                                <input type="date" class="form-control" id="release_date" name="release_date"
                                    value="{{ old('release_date', isset($book) && $book->release_date ? $book->release_date->format('Y-m-d') : '') }}"
                                    required>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="length" class="form-label">Length (cm)</label>
                                    <input type="number" class="form-control" id="length" name="length"
                                        value="{{ old('length', $book->length ?? '') }}" step="0.1" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="width" class="form-label">Width (cm)</label>
                                    <input type="number" class="form-control" id="width" name="width"
                                        value="{{ old('width', $book->width ?? '') }}" step="0.1" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="weight" class="form-label">Weight (g)</label>
                                    <input type="number" class="form-control" id="weight" name="weight"
                                        value="{{ old('weight', $book->weight ?? '') }}" step="0.1" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="page" class="form-label">Page</label>
                                    <input type="number" class="form-control" id="page" name="page"
                                        value="{{ old('page', $book->page ?? '') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-success">{{ isset($book) ? 'Save Change' : 'Add Book' }}</button>
                @include('components.button', [
                    'route' => route('admin.dashboard'),
                    'label' => 'Back',
                    'type' => 'secondary',
                ])
            </div>
        </form>
    </div>

    <div class="modal fade" id="unsavedChangesModal" tabindex="-1" aria-labelledby="unsavedChangesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unsavedChangesModalLabel">Unsaved Changes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    You have unsaved changes. Are you sure you want to discard them?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="{{ route('admin.books.index') }}" id="discard-changes-btn"
                        class="btn btn-danger">Discard</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let isFormDirty = false;
        let backUrl = "{{ route('admin.books.index') }}";

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('book-form');
            form.addEventListener('input', () => {
                isFormDirty = true;
            });

            const backButton = document.getElementById('back-button');
            backButton.addEventListener('click', function(e) {
                if (isFormDirty) {
                    e.preventDefault();
                    const confirmationModal = new bootstrap.Modal(document.getElementById(
                        'unsavedChangesModal'));
                    confirmationModal.show();
                }
            });
        });

        function previewCover() {
            const coverInput = document.querySelector('#image');
            const coverPreview = document.querySelector('#cover-preview');
            isFormDirty = true;

            if (coverInput.files && coverInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    coverPreview.src = e.target.result;
                }
                reader.readAsDataURL(coverInput.files[0]);
            }
        }
    </script>
@endpush
