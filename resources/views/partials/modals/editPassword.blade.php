<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPasswordModalLabel">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-edit-password" data-url="{{ route('account.password.update') }}">
                <div class="modal-body">
                    <div class="alert alert-danger" id="password-errors" style="display:none;"></div>

                    <div class="mb-3">
                        <label for="current_password_input" class="form-label">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" id="current_password_input"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password_input" class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control" id="password_input" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation_input" class="form-label">Ulangi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            id="password_confirmation_input" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
