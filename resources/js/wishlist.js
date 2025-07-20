document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const loginUrl = document.body.dataset.loginUrl;

    const initWishlistButtons = (selector) => {
        document.querySelectorAll(selector).forEach(button => {
            button.addEventListener('click', async function (event) {
                event.preventDefault();
                event.stopPropagation();

                const bookId = this.dataset.bookId;
                if (!bookId) {
                    console.error('Book ID not found!');
                    return;
                }

                try {
                    const response = await fetch(`/wishlist/toggle/${bookId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        }
                    });

                    if (response.status === 401) {
                        window.location.href = loginUrl;
                        return;
                    }

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();
                    const heartIcon = this.querySelector('.bi-heart');
                    const heartFillIcon = this.querySelector('.bi-heart-fill');

                    if (data.status === 'added') {
                        heartIcon.classList.add('d-none');
                        heartFillIcon.classList.remove('d-none');
                    } else if (data.status === 'removed') {
                        heartIcon.classList.remove('d-none');
                        heartFillIcon.classList.add('d-none');
                    }

                } catch (error) {
                    console.error('There was a problem with the fetch operation:', error);
                }
            });
        });
    };

    initWishlistButtons('.btn-wishlist');
});