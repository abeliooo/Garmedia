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
                    <p class="fs-5">Selamat datang, <strong class="text-primary">{{ $admin->name }}</strong>!</p>
                    <p class="text-muted">ID Admin Anda: {{ $admin->admin_id }}</p>
                    <hr>
                    <p>Apa yang ingin Anda lakukan hari ini?</p>
                    <div class="d-grid gap-2 d-md-flex">
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle-fill me-2"></i>Tambah Buku Baru
                        </a>
                        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                            <i class="bi bi-book-fill me-2"></i>Kelola Daftar Buku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
