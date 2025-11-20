import './bootstrap';
import './currency-input';

import Alpine from 'alpinejs';
import flatpickr from 'flatpickr';
import monthSelectPlugin from 'flatpickr/dist/plugins/monthSelect/index.js';
import 'flatpickr/dist/plugins/monthSelect/style.css';

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

    // Initialize for month inputs
    flatpickr('input[type="month"]', {
        plugins: [new monthSelectPlugin({
            shorthand: true, //defaults to false
            dateFormat: "Y-m", //defaults to "F Y"
        })],
        altInput: true,
        altFormat: 'M Y',
        allowInput: true,
    });
});
