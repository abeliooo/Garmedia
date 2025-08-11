@extends('layout.app')

@section('content')
<div id="account-page-data"
    data-update-field-url="{{ route('account.update.field') }}"
    data-update-password-url="{{ route('account.update.password') }}"
    data-update-picture-url="{{ route('account.update.picture') }}">
</div>
<div class="container my-5">
    <h2 class="fw-bold my-5">Account</h2>

    <div id="success-alert" class="alert alert-success d-none"></div>

    <div class="row">
        <div class="col-md-4 text-center">
            @if ($user->profile_picture && $user->profile_picture !== 'images/profile/default.png')
            <div class="profile-picture-container">
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
                <div class="overlay" data-bs-toggle="modal" data-bs-target="#updateProfilePictureModal">
                    Change Picture
                </div>
            </div>
            @else
            <div class="profile-icon-default" data-bs-toggle="modal" data-bs-target="#updateProfilePictureModal">
                <i class="bi bi-person-circle" style="font-size: 150px; color: #6c757d;"></i>
                <div class="text-muted mt-2">Click to add photo</div>
            </div>
            @endif

            <p class="text-muted mt-2 fs-6">
                Format must be .jpg, .jpeg, .png<br>maximum image size 2MB
            </p>
        </div>

        <div class="col-md-8">
            <h5 class="fw-bold mb-2 fs-3">Profile</h5>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="text-muted fs-5">Username</div>
                    <div class="fw-bold fs-4">{{ $user->name }}</div>
                </div>
                <a href="#" data-bs-toggle="modal" data-bs-target="#updateFieldModal"
                    data-field-name="name" data-field-value="{{ $user->name }}" data-field-label="Username" data-field-type="text"><i class="bi bi-pencil-fill"></i></a>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="text-muted fs-5">Email</div>
                    <div class="fw-bold fs-4">{{ $user->email }}</div>
                </div>
                <a href="#" data-bs-toggle="modal" data-bs-target="#updateFieldModal"
                    data-field-name="email" data-field-value="{{ $user->email }}" data-field-label="Email Address" data-field-type="email"><i class="bi bi-pencil-fill"></i></a>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="text-muted fs-5">Password</div>
                    <div class="fw-bold fs-4">••••••••</div>
                </div>
                <a href="#" data-bs-toggle="modal" data-bs-target="#updatePasswordModal"><i class="bi bi-pencil-fill"></i></a>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="text-muted fs-5">Gender</div>
                    <div class="fw-bold text-capitalize fs-4">{{ $user->gender ?? 'Not set' }}</div>
                </div>
                <a href="#" data-bs-toggle="modal" data-bs-target="#updateFieldModal"
                    data-field-name="gender" data-field-value="{{ $user->gender }}" data-field-label="Gender" data-field-type="select" data-options='{"male":"Male", "female":"Female", "prefer not to say":"Prefer not to say"}'><i class="bi bi-pencil-fill"></i></a>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="text-muted fs-5">Birth Date</div>
                    <div class="fw-bold fs-4">{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->translatedFormat('d F Y') : 'Not set' }}</div>
                </div>
                <a href="#" data-bs-toggle="modal" data-bs-target="#updateFieldModal"
                    data-field-name="date_of_birth" data-field-value="{{ $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '' }}" data-field-label="Birth Date" data-field-type="date"><i class="bi bi-pencil-fill"></i></a>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="text-muted fs-5">Phone Number</div>
                    <div class="fw-bold fs-4">{{ $user->phone_number ?? 'Not set' }}</div>
                </div>
                <a href="#" data-bs-toggle="modal" data-bs-target="#updateFieldModal"
                    data-field-name="phone_number" data-field-value="{{ $user->phone_number }}" data-field-label="Phone Number" data-field-type="tel"><i class="bi bi-pencil-fill"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Password Update Modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updatePasswordForm">
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="password-error-alert"></div>
                    <div class="mb-3">
                        <label for="current_password_pass" class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" id="current_password_pass" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Field Update Modal -->
<div class="modal fade" id="updateFieldModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateFieldForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateFieldModalTitle">Update Field</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="field-error-alert"></div>

                    <div id="modal-input-container" class="mb-3"></div>

                    <input type="hidden" name="field_name" id="modal_field_name">

                    <div class="mb-3">
                        <label for="current_password_field" class="form-label">Verify with Password</label>
                        <input type="password" class="form-control" id="current_password_field" name="current_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Profile Picture Update Modal -->
<div class="modal fade" id="updateProfilePictureModal" tabindex="-1" aria-labelledby="updateProfilePictureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateProfilePictureForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfilePictureModalLabel">Change Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="picture-error-alert"></div>

                    <div class="mb-3">
                        <label for="profile_picture_input" class="form-label">Select New Image</label>
                        <input class="form-control" type="file" name="profile_picture" id="profile_picture_input" accept="image/jpeg,image/jpg,image/png" required>
                        <div class="form-text">Format: JPG, JPEG, PNG. Maximum 2MB.</div>
                    </div>
                    <div class="mb-3">
                        <label for="picture_password_field" class="form-label">Verify with Password</label>
                        <input type="password" class="form-control" id="picture_password_field" name="current_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Picture</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
@vite(['resources/js/account.js'])
@endpush