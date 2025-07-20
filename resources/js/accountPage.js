document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('account-form');
    const editBtn = document.getElementById('edit-profile-btn');
    const saveBtn = document.getElementById('save-changes-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const profilePicInput = document.getElementById('profile_picture_input');
    const profilePicPreview = document.getElementById('profile-picture-preview');
    const originalPicSrc = profilePicPreview?.src || '';

    const inputs = form.querySelectorAll('input[name], select[name]');

    function toggleEditMode(isEditing) {
        inputs.forEach(input => {
            const isFileInput = input.type === 'file';
            const isEmailOrName = input.name === 'email' || input.name === 'name';

            if (isFileInput) {
                input.disabled = !isEditing;
            } else if (input.tagName === 'SELECT') {
                input.disabled = !isEditing;
            } else {
                input.readOnly = !isEditing;
            }
        });

        editBtn?.classList.toggle('d-none', isEditing);
        saveBtn?.classList.toggle('d-none', !isEditing);
        cancelBtn?.classList.toggle('d-none', !isEditing);
    }

    editBtn?.addEventListener('click', () => {
        toggleEditMode(true);
    });

    cancelBtn?.addEventListener('click', () => {
        form.reset();
        if (profilePicPreview && originalPicSrc) {
            profilePicPreview.src = originalPicSrc;
        }
        toggleEditMode(false);
    });

    profilePicInput?.addEventListener('change', function () {
        const file = this.files?.[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                if (profilePicPreview) {
                    profilePicPreview.src = e.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // Default mode: not editing
    toggleEditMode(false);
});
