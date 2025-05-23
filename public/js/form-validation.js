document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const phoneInput = document.getElementById('phone');

    if (phoneInput) {
        // Format phone number as user types
        phoneInput.addEventListener('input', function (e) {
            // Remove any non-digit characters
            let phone = e.target.value.replace(/\D/g, '');

            // Remove leading 0 or 62
            if (phone.startsWith('0')) {
                phone = phone.substring(1);
            } else if (phone.startsWith('62')) {
                phone = phone.substring(2);
            }

            // Update input value
            e.target.value = phone;
        });
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            const phone = phoneInput.value.replace(/\D/g, '');

            // Basic validation
            if (phone.length < 10 || phone.length > 13) {
                e.preventDefault();
                alert('Nomor WhatsApp harus antara 10-13 digit.');
                return;
            }

            // If validation passes, format the number properly before submission
            phoneInput.value = phone;
        });
    }
});
