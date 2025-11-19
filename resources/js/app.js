import './bootstrap';

import Alpine from 'alpinejs';
import flatpickr from 'flatpickr';

window.Alpine = Alpine;

Alpine.start();

// Initialize Flatpickr for all date inputs
document.addEventListener('DOMContentLoaded', function() {
    // Initialize for date inputs
    flatpickr('input[type="date"]', {
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'M d, Y',
        allowInput: true,
    });
});
