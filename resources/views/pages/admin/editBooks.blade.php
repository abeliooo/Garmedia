@extends('layout.guest')

@section('content')
<div class="container-fluid my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bolder">Kelola Daftar Buku</h1>
        <a href="#" class="btn btn-primary">Tambah Buku Baru</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="#" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Cari buku berdasarkan judul atau penulis..." value="{{ request('search') }}">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
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
                            <th scope="col">Harga</th>
                            <th scope="col">Halaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    <a href="#" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                </td>
                                <td>
                                    <img src="{{ asset($book->image) }}" alt="{{ $book->title }}" width="50">
                                </td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->format }}</td>
                                <td>{{ $book->penerbit }}</td>
                                <td>{{ $book->isbn }}</td>
                                <td>Rp {{ number_format($book->harga, 0, ',', '.') }}</td>
                                <td>{{ $book->halaman }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection