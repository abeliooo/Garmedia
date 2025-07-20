@extends('layout.app')

@section('content')
    <div class="container my-5">
        <h2 class="fw-bold my-5">Account</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($user->profile_picture)
                        <div class="rounded-circle d-flex justify-content-center align-items-center bg-light border border-dark mx-auto"
                            style="width: 250px; height: 250px;">
                            <i class="bi bi-person-fill fs-1 text-secondary"></i>
                        </div>
                    @else
                        <div class="rounded-circle border border-dark mx-auto profile-circle"></div>
                    @endif

                    <label for="profile_picture_input" class="btn btn-outline-dark btn-sm mt-4 fs-3">Ubah Foto Profil</label>
                    <input type="file" name="profile_picture" id="profile_picture_input" class="d-none">

                    <p class="text-muted mt-2 fs-6">Format must be .jpg, .jpeg, .png<br>maximum image size 2MB</p>
                </div>

                <div class="col-md-8">
                    <h5 class="fw-bold mb-3 fs-4">Profile</h5>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="text-muted fs-5">Username</div>
                            <div class="fw-bold fs-4">{{ $user->name }}</div>
                        </div>
                        <a href="#"><i class="bi bi-pencil-fill"></i></a>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="text-muted fs-5">Email</div>
                            <div class="fw-bold fs-4">{{ $user->email }}</div>
                        </div>
                        <a href="#"><i class="bi bi-pencil-fill"></i></a>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="text-muted fs-5">Password</div>
                            <div class="fw-bold fs-4">••••••••</div>
                        </div>
                        <a href="#"><i class="bi bi-pencil-fill"></i></a>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="text-muted fs-5">Gender</div>
                            <div class="fw-bold text-capitalize fs-4">{{ $user->gender }}</div>
                        </div>
                        <a href="#"><i class="bi bi-pencil-fill"></i></a>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="text-muted fs-5">Birth Date</div>
                            <div class="fw-bold fs-4">{{ \Carbon\Carbon::parse($user->birth_date)->translatedFormat('d F Y') }}
                            </div>
                        </div>
                        <a href="#"><i class="bi bi-pencil-fill"></i></a>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="text-muted fs-5">Phone Number</div>
                            <div class="fw-bold fs-4">{{ $user->phone_number }}</div>
                        </div>
                        <a href="#"><i class="bi bi-pencil-fill"></i></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection