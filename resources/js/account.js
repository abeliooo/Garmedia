document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const successAlert = document.getElementById('success-alert');
    const pageData = document.getElementById('account-page-data');
    const updateFieldUrl = pageData.getAttribute('data-update-field-url');
    const updatePasswordUrl = pageData.getAttribute('data-update-password-url');
    const updatePictureUrl = pageData.getAttribute('data-update-picture-url');

    function displayErrors(alertElement, errors) {
        alertElement.innerHTML = '';
        if (typeof errors === 'string') {
            alertElement.innerHTML = errors;
        } else if (typeof errors === 'object' && errors !== null) {
            const errorList = Object.values(errors).map(err => {
                if (Array.isArray(err)) {
                    return `<li>${err[0]}</li>`;
                } else {
                    return `<li>${err}</li>`;
                }
            }).join('');
            alertElement.innerHTML = `<ul>${errorList}</ul>`;
        } else {
            alertElement.innerHTML = 'An unexpected error occurred.';
        }
        alertElement.classList.remove('d-none');
    }

    function displaySuccess(message) {
        successAlert.innerHTML = message;
        successAlert.classList.remove('d-none');
        // Hide success message after 3 seconds
        setTimeout(() => {
            successAlert.classList.add('d-none');
        }, 3000);
    }

    async function handleFormSubmit(url, formData, errorAlert, successMessage = null) {
        successAlert.classList.add('d-none');
        errorAlert.classList.add('d-none');

        // Show loading state
        const submitBtn = errorAlert.closest('.modal').querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData,
            });

            let data;
            try {
                data = await response.json();
            } catch (parseError) {
                console.error("JSON parse error:", parseError);
                throw new Error("Invalid response from server");
            }

            if (response.ok) {
                // Success - close modal and show success message
                const modal = bootstrap.Modal.getInstance(errorAlert.closest('.modal'));
                if (modal) {
                    modal.hide();
                }
                
                if (successMessage) {
                    displaySuccess(successMessage);
                } else if (data.message) {
                    displaySuccess(data.message);
                } else if (data.success === true) {
                    displaySuccess("Update successful!");
                } else if (typeof data.success === 'string') {
                    displaySuccess(data.success);
                } else {
                    displaySuccess("Update completed successfully!");
                }

                // Reload page after successful update to show changes
                setTimeout(() => {
                    window.location.reload();
                }, 1500);

            } else {
                // Show validation errors
                if (data.errors) {
                    displayErrors(errorAlert, data.errors);
                } else if (data.error) {
                    displayErrors(errorAlert, data.error);
                } else {
                    displayErrors(errorAlert, "An error occurred. Please try again.");
                }
            }

        } catch (error) {
            console.error("Fetch error:", error);
            displayErrors(errorAlert, "Network error occurred. Please check your connection and try again.");
        } finally {
            // Restore button state
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    }

    // Update Field Modal Handler
    const updateFieldModal = document.getElementById('updateFieldModal');
    if (updateFieldModal) {
        updateFieldModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const fieldName = button.getAttribute('data-field-name');
            const fieldValue = button.getAttribute('data-field-value');
            const fieldLabel = button.getAttribute('data-field-label');
            const fieldType = button.getAttribute('data-field-type');

            const modalTitle = updateFieldModal.querySelector('.modal-title');
            const inputContainer = updateFieldModal.querySelector('#modal-input-container');
            const fieldNameInput = updateFieldModal.querySelector('#modal_field_name');

            modalTitle.textContent = `Update ${fieldLabel}`;
            fieldNameInput.value = fieldName;

            let inputHtml = `<label for="modal_field_value" class="form-label">${fieldLabel}</label>`;

            if (fieldType === 'select') {
                const options = JSON.parse(button.getAttribute('data-options'));
                inputHtml += `<select name="field_value" id="modal_field_value" class="form-select">`;
                for (const [value, text] of Object.entries(options)) {
                    const selected = value === fieldValue ? 'selected' : '';
                    inputHtml += `<option value="${value}" ${selected}>${text}</option>`;
                }
                inputHtml += `</select>`;
            } else {
                inputHtml += `<input type="${fieldType}" name="field_value" id="modal_field_value" class="form-control" value="${fieldValue || ''}">`;
            }

            inputContainer.innerHTML = inputHtml;
        });

        const fieldForm = document.getElementById('updateFieldForm');
        fieldForm.addEventListener('submit', function (e) {
            e.preventDefault();
            handleFormSubmit(updateFieldUrl, new FormData(fieldForm), document.getElementById('field-error-alert'));
        });
    }

    // Update Password Form Handler
    const passwordForm = document.getElementById('updatePasswordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function (e) {
            e.preventDefault();
            handleFormSubmit(updatePasswordUrl, new FormData(passwordForm), document.getElementById('password-error-alert'));
        });
    }

    // Update Profile Picture Form Handler
    const pictureForm = document.getElementById('updateProfilePictureForm');
    if (pictureForm) {
        pictureForm.addEventListener('submit', function (e) {
            e.preventDefault();
            
            const fileInput = document.getElementById('profile_picture_input');
            const file = fileInput.files[0];
            
            // Client-side validation
            if (!file) {
                displayErrors(document.getElementById('picture-error-alert'), "Please select an image file.");
                return;
            }

            // Check file size (2MB = 2048KB)
            if (file.size > 2048 * 1024) {
                displayErrors(document.getElementById('picture-error-alert'), "File size must be less than 2MB.");
                return;
            }

            // Check file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                displayErrors(document.getElementById('picture-error-alert'), "Only JPG, JPEG, and PNG files are allowed.");
                return;
            }

            handleFormSubmit(updatePictureUrl, new FormData(pictureForm), document.getElementById('picture-error-alert'));
        });
    }

    // Reset modals when closed
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('hidden.bs.modal', function () {
            const form = modal.querySelector('form');
            if (form) form.reset();
            const errorAlert = modal.querySelector('.alert-danger');
            if (errorAlert) {
                errorAlert.classList.add('d-none');
                errorAlert.innerHTML = '';
            }
        });
    });
});