@extends('layout.guest')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bold mb-0">Admin Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <p class="fs-5">Welcome, <strong class="text-primary">{{ $admin->name }}</strong>!</p>
                        <p class="text-muted">Admin ID : {{ $admin->admin_id }}</p>
                        <hr>
                        <p>What you want to do?</p>
                        <div class="d-grid gap-2 d-md-flex">
                            <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle-fill me-2"></i>Add Book
                            </a>
                            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                                <i class="bi bi-book-fill me-2"></i>Manage Book
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
