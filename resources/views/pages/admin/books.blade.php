@extends('layout.guest')

@section('content')
    <div class="container-fluid my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bolder">Manage Book</h1>
            <div class="d-flex">
                @include('components.button', [
                    'route' => route('admin.dashboard'),
                    'label' => 'Back',
                    'type' => 'secondary',
                ])
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.books.index') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search"
                            placeholder="Search Book Base On Title Or Author..." value="{{ request('search') }}">
                        <button class="btn btn-secondary" type="submit">Search</button>
                    </div>
                </form>

                <div class="table-responsive small">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Action</th>
                                <th scope="col">Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Format</th>
                                <th scope="col">Publisher</th>
                                <th scope="col">ISBN</th>
                                <th scope="col">Release Date</th>
                                <th scope="col">Page</th>
                                <th scope="col">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($books as $book)
                                <tr>
                                    <th scope="row">{{ $books->firstItem() + $loop->index }}</th>
                                    <td>
                                        <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                    <td style="min-width: 200px;">{{ $book->title }}</td>
                                    <td style="min-width: 150px;">{{ $book->author }}</td>
                                    <td>{{ is_array($book->formats) ? implode(', ', $book->formats) : '' }}</td>
                                    <td>{{ $book->publisher }}</td>
                                    <td>{{ $book->isbn }}</td>
                                    <td>{{ $book->release_date->format('Y-m-d') }}</td>
                                    <td>{{ $book->page }}</td>
                                    <td>{{ $book->price }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No Book Found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection