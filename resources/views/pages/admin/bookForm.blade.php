@extends('layout.app')

@section('content')
<div class="container my-5">
    <h1 class="fw-bolder mb-4">{{ isset($book) ? 'Edit Buku' : 'Tambah Buku Baru' }}</h1>

    {{-- Form mengarah ke route yang berbeda tergantung mode --}}
    <form action="{{ isset($book) ? route('admin.books.update', $book->id) : route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- Method spoofing untuk edit --}}
        @if (isset($book))
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-8">
                {{-- Judul, Author, Deskripsi, Penerbit, ISBN --}}
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Penulis</label>
                            <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="content" rows="5">{{ old('content', $book->content ?? '') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="penerbit" class="form-label">Penerbit</label>
                                <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ old('penerbit', $book->penerbit ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="isbn" class="form-label">ISBN</label>
                                <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn ?? '') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                {{-- Cover, Format, Bahasa, Dimensi, Halaman, Tanggal Terbit --}}
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="cover" class="form-label">Cover Buku</label>
                            @if(isset($book) && $book->image)
                                <img src="{{ asset($book->image) }}" class="img-fluid rounded mb-2 d-block" alt="Current Cover">
                            @endif
                            <input type="file" class="form-control" id="cover" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="format" class="form-label">Format</label>
                            <select class="form-select" id="format" name="format" required>
                                <option value="soft cover" @selected(old('format', $book->format ?? '') == 'soft cover')>Soft Cover</option>
                                <option value="hard cover" @selected(old('format', $book->format ?? '') == 'hard cover')>Hard Cover</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bahasa" class="form-label">Bahasa</label>
                            <input type="text" class="form-control" id="bahasa" name="bahasa" value="{{ old('bahasa', $book->bahasa ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                            <input type="date" class="form-control" id="tanggal_terbit" name="tanggal_terbit" value="{{ old('tanggal_terbit', $book->tanggal_terbit ?? '') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="panjang" class="form-label">Panjang (cm)</label>
                                <input type="number" class="form-control" id="panjang" name="panjang" value="{{ old('panjang', $book->panjang ?? '') }}" step="0.1" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="lebar" class="form-label">Lebar (cm)</label>
                                <input type="number" class="form-control" id="lebar" name="lebar" value="{{ old('lebar', $book->lebar ?? '') }}" step="0.1" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="berat" class="form-label">Berat (g)</label>
                                <input type="number" class="form-control" id="berat" name="berat" value="{{ old('berat', $book->berat ?? '') }}" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="halaman" class="form-label">Halaman</label>
                                <input type="number" class="form-control" id="halaman" name="halaman" value="{{ old('halaman', $book->halaman ?? '') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-success">{{ isset($book) ? 'Simpan Perubahan' : 'Tambah Buku' }}</button>
            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
