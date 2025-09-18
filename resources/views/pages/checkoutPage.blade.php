@extends('layout.app')

@section('content')
<div class="container my-5">
    <h1 class="fw-bolder mb-4">Checkout</h1>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-7">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Alamat Pengiriman</h5>
                        @if($addresses->isEmpty())
                        <p class="text-muted">Anda belum memiliki alamat tersimpan. <a href="#">Tambah Alamat</a></p>
                        @else
                        @foreach($addresses as $address)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="address_id" id="address{{ $address->id }}" value="{{ $address->id }}">
                            <label class="form-check-label" for="address{{ $address->id }}">
                                <strong>{{ $address->label }}</strong><br>
                                {{ $address->recipient_name }}
                                ({{ $address->phone_number ?? Auth::user()->phone_number }})<br>
                                {{ $address->full_address }}
                            </label>
                        </div>
                        @if(!$loop->last)
                        <hr> @endif
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Metode Pengiriman</h5>
                        <div class="form-check">
                            <input class="form-check-input shipping-method" type="radio" name="shipping_method" id="pickup" value="pickup" checked>
                            <label class="form-check-label" for="pickup">
                                <strong>Ambil di Tempat</strong> (Rp 0)<br>
                                <small class="text-muted">Gedung Kompas Gramedia, Palmerah. Jl. Palmerah Barat No. 29 - 37, Gelora, Tanah Abang, Jakarta Pusat, DKI Jakarta, 10270</small>
                            </label>
                        </div>
                        <hr>
                        <div class="form-check">
                            <input class="form-check-input shipping-method" type="radio" name="shipping_method" id="courier" value="courier">
                            <label class="form-check-label" for="courier">
                                <strong>Kurir Garmedia</strong> (Rp 6.500)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Ringkasan Pesanan</h5>
                        @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <p class="mb-0">{{ $item->title }} <span class="text-muted">x {{ $item->pivot->quantity }}</span></p>
                                <small class="text-muted">{{ $item->author }}</small>
                            </div>
                            <span class="fw-medium">Rp {{ number_format($item->price * $item->pivot->quantity, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span id="subtotal" data-value="{{ $subtotal }}">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Biaya Kirim</span>
                            <span id="shipping-cost" data-value="0">Rp 0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total Akhir</span>
                            <span id="final-total">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 mt-4 py-2">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === BAGIAN YANG SUDAH ADA ===
        const shippingMethods = document.querySelectorAll('.shipping-method');
        const subtotalEl = document.getElementById('subtotal');
        const shippingCostEl = document.getElementById('shipping-cost');
        const finalTotalEl = document.getElementById('final-total');

        // === BAGIAN BARU: Pilih semua input alamat ===
        const addressRadios = document.querySelectorAll('input[name="address_id"]');
        const addressContainer = document.querySelector('.card-body .form-check').parentNode; // Ambil kontainer alamat

        const subtotal = parseFloat(subtotalEl.getAttribute('data-value'));
        const courierCost = 6500;

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number).replace('IDR', 'Rp');
        }

        function updateSummary() {
            const selectedMethod = document.querySelector('input[name="shipping_method"]:checked').value;
            let shippingCost = 0;

            if (selectedMethod === 'courier') {
                shippingCost = courierCost;
            }

            const finalTotal = subtotal + shippingCost;

            shippingCostEl.textContent = formatRupiah(shippingCost);
            finalTotalEl.textContent = formatRupiah(finalTotal);
        }

        // === BAGIAN BARU: Fungsi untuk disable/enable alamat ===
        function toggleAddressState() {
            const selectedMethod = document.querySelector('input[name="shipping_method"]:checked').value;

            if (selectedMethod === 'pickup') {
                // Jika "Ambil di Tempat" dipilih
                addressRadios.forEach(radio => {
                    radio.disabled = true;
                    radio.checked = false; // Hapus pilihan alamat jika ada
                });
                addressContainer.classList.add('address-disabled'); // Tambah class untuk efek abu-abu
            } else {
                // Jika "Kurir Garmedia" dipilih
                addressRadios.forEach(radio => {
                    radio.disabled = false;
                });
                addressContainer.classList.remove('address-disabled'); // Hapus class abu-abu
            }
        }


        shippingMethods.forEach(method => {
            method.addEventListener('change', function() {
                updateSummary();
                toggleAddressState(); // Panggil fungsi baru di sini
            });
        });

        // Jalankan kedua fungsi saat halaman pertama kali dimuat
        updateSummary();
        toggleAddressState();
    });
</script>
@endpush

@push('styles')
<style>
    .address-disabled {
        opacity: 0.5;
        pointer-events: none;
        /* Membuat elemen tidak bisa diklik */
    }
</style>
@endpush