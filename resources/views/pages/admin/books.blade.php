@extends('layout.app')

@section('content')
<div class="container-fluid my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bolder">Kelola Daftar Buku</h1>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">Tambah Buku Baru</a>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Search Bar -->
            <form action="{{ route('admin.books.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Cari buku berdasarkan judul atau penulis..." value="{{ request('search') }}">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>

            <!-- Tabel yang bisa di-scroll -->
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Aksi</th>
                            <th scope="col">Cover</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Author</th>
                            <th scope="col">Format</th>
                            <th scope="col">Penerbit</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Tanggal Terbit</th>
                            <th scope="col">Halaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                </td>
                                <td>
                                    <img src="{{ asset($book->image) }}" alt="{{ $book->title }}" width="50" class="rounded">
                                </td>
                                <td style="min-width: 200px;">{{ $book->title }}</td>
                                <td style="min-width: 150px;">{{ $book->author }}</td>
                                <td>{{ $book->format }}</td>
                                <td>{{ $book->penerbit }}</td>
                                <td>{{ $book->isbn }}</td>
                                <td>{{ $book->tanggal_terbit }}</td>
                                <td>{{ $book->halaman }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data buku yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
