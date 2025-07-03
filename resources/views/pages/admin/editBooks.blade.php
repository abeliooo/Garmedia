@extends('layout.guest')

@section('content')
<div class="container-fluid my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bolder">Edit Book</h1>
        <div class="d-flex">
            @include('components.button', [
                'route' => url()->previous(),
                'label' => 'Back',
                'type'  => 'secondary'
            ])
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="#" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search Book Base On Title Or Author..." value="{{ request('search') }}">
                    <button class="btn btn-secondary" type="submit">Search</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Action</th>
                            <th scope="col">Cover</th>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Format</th>
                            <th scope="col">Publisher</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Price</th>
                            <th scope="col">Page</th>
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
                                <td colspan="10" class="text-center">There's No Data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection