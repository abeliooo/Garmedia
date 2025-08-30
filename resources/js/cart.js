document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('.btn-add-to-cart').forEach(button => {
        button.addEventListener('click', async function (event) {
            event.preventDefault();
            const bookId = this.dataset.bookId;
            
            const originalText = this.innerHTML;
            this.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...`;
            this.disabled = true;

            try {
                const response = await fetch(`/cart/add/${bookId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to add to cart');
                }

                const data = await response.json();

                console.log(data.message);

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 1000);

            } catch (error) {
                console.error('Error adding to cart:', error);
                this.innerHTML = 'Error!';
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 2000);
            }
        });
    });
});