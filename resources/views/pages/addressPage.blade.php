@extends('layout.app')

@section('content')
<div class="container py-5">
    <div class="address-card garmedia-warehouse mb-5">
        <h5>Garmedia Shipping Address</h5>
        <p class="mb-1">
            Gedung Kompas Gramedia, Palmerah<br>
            Jl. Palmerah Barat No. 29 - 37, Gelora, Tanah Abang<br>
            Jakarta Pusat, DKI Jakarta, 10270
        </p>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Your Address</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
            Add New Address
        </button>
    </div>

    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @forelse($addresses as $address)
    <div class="address-card">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5>
                    <span class="address-label {{ $address->is_primary ? 'primary-badge' : '' }}">
                        {{ $address->label }}
                    </span>
                    @if($address->is_primary)
                    <span class="badge bg-success ms-2">Primary</span>
                    @endif
                </h5>
                <p class="mb-1">{{ $address->full_address }}</p>
                <p class="mb-1">{{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
            </div>
            <div class="address-actions mt-2 d-flex">
                <button type="button" class="btn btn-link p-0 text-decoration-none" data-bs-toggle="modal" data-bs-target="#editAddressModal-{{ $address->id }}">
                    Edit
                </button>

                <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this address?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link text-danger p-0 ms-3">Remove</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editAddressModal-{{ $address->id }}" tabindex="-1" aria-labelledby="editAddressModalLabel-{{ $address->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editAddressModalLabel-{{ $address->id }}">Edit Address</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addresses.update', $address->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="label-{{ $address->id }}" class="form-label">Address Label</label>
                            <input type="text" class="form-control" id="label-{{ $address->id }}" name="label" value="{{ $address->label }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="full_address-{{ $address->id }}" class="form-label">Full Address</label>
                            <textarea class="form-control" id="full_address-{{ $address->id }}" name="full_address" rows="3" required>{{ $address->full_address }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city-{{ $address->id }}" class="form-label">City</label>
                                <input type="text" class="form-control" id="city-{{ $address->id }}" name="city" value="{{ $address->city }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="province-{{ $address->id }}" class="form-label">Province</label>
                                <input type="text" class="form-control" id="province-{{ $address->id }}" name="province" value="{{ $address->province }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="postal_code-{{ $address->id }}" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code-{{ $address->id }}" name="postal_code" value="{{ $address->postal_code }}" required>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_primary" value="1" id="is_primary-{{ $address->id }}" {{ $address->is_primary ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_primary-{{ $address->id }}">
                                Set as primary address
                            </label>
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
    @empty
    <div class="address-card text-center">
        <p>You don't have any saved addresses yet. Please add a new address.</p>
    </div>
    @endforelse

    @include('partials.modals.addressModal')

</div>
@endsection