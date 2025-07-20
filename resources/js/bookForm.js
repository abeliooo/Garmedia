function previewCover() {
    const coverInput = document.querySelector('#image');
    const coverPreview = document.querySelector('#cover-preview');

    document.getElementById('book-form').dataset.dirty = 'true';

    if (coverInput.files && coverInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            coverPreview.src = e.target.result;
        }
        reader.readAsDataURL(coverInput.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('book-form');
    if (!form) return;

    form.addEventListener('input', () => {
        form.dataset.dirty = 'true';
    });

    document.querySelectorAll('a').forEach(link => {
        const backRoutes = ['admin.dashboard', 'admin.books.index'];
        if (link.href.includes('dashboard') || link.href.includes('books')) {
            link.addEventListener('click', function (e) {
                if (form.dataset.dirty === 'true') {
                    e.preventDefault();
                    const confirmationModal = new bootstrap.Modal(document.getElementById('unsavedChangesModal'));
                    document.getElementById('discard-changes-btn').href = this.href;
                    confirmationModal.show();
                }
            });
        }
    });

    const coverInput = document.querySelector('#image');
    if (coverInput) {
        coverInput.setAttribute('onchange', 'previewCover()');
    }
});