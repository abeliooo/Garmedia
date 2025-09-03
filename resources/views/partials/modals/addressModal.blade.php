<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addAddressModalLabel">Add New Address</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="label" class="form-label">Address Label</label>
                        <input type="text" class="form-control" id="label" name="label" placeholder="Contoh: Rumah, Kantor" required>
                    </div>
                    <div class="mb-3">
                        <label for="full_address" class="form-label">Full Address</label>
                        <textarea class="form-control" id="full_address" name="full_address" rows="3" placeholder="Nama Jalan, Nomor Rumah, RT/RW" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="province" class="form-label">Province</label>
                            <input type="text" class="form-control" id="province" name="province" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">Postal Code</label>
                        <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_primary" value="1" id="is_primary">
                        <label class="form-check-label" for="is_primary">
                            Set as primary address
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>