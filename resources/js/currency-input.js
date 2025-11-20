// Currency Input Formatter for VND
document.addEventListener('DOMContentLoaded', function() {
    // Function to format number to VND format
    function formatToVND(value) {
        // Remove all non-numeric characters
        let numericValue = value.replace(/[^\d]/g, '');

        // If empty, return empty
        if (!numericValue) return '';

        // Add dots as thousand separators from right to left
        return numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Function to handle input formatting
    function handleCurrencyInput(event) {
        let input = event.target;
        let cursorPosition = input.selectionStart;
        let originalValue = input.value;

        // Format the value
        let formattedValue = formatToVND(originalValue);

        // Only update if the formatted value is different
        if (formattedValue !== originalValue) {
            input.value = formattedValue;

            // Try to maintain cursor position
            let newCursorPosition = cursorPosition + (formattedValue.length - originalValue.length);
            if (newCursorPosition >= 0 && newCursorPosition <= formattedValue.length) {
                input.setSelectionRange(newCursorPosition, newCursorPosition);
            }
        }
    }

    // Function to handle input blur (when user leaves the field)
    function handleCurrencyBlur(event) {
        let input = event.target;
        let value = input.value;

        if (value && value.trim() !== '') {
            // Ensure it's properly formatted
            input.value = formatToVND(value);
        }
    }

    // Function to handle input focus (when user enters the field)
    function handleCurrencyFocus(event) {
        let input = event.target;
        let value = input.value;

        // Remove formatting for easier editing
        if (value && value.trim() !== '') {
            // Remove dots
            let cleanValue = value.replace(/\./g, '');
            input.value = cleanValue;
        }
    }

    // Add event listeners to currency inputs
    function initializeCurrencyInputs() {
        // Target inputs with data-currency="vnd" attribute or class "currency-input"
        let currencyInputs = document.querySelectorAll('input[data-currency="vnd"], input.currency-input');

        currencyInputs.forEach(function(input) {
            // Remove existing listeners to avoid duplicates
            input.removeEventListener('input', handleCurrencyInput);
            input.removeEventListener('blur', handleCurrencyBlur);
            input.removeEventListener('focus', handleCurrencyFocus);

            // Add listeners
            input.addEventListener('input', handleCurrencyInput);
            input.addEventListener('blur', handleCurrencyBlur);
            input.addEventListener('focus', handleCurrencyFocus);
        });
    }

    // Initialize on page load
    initializeCurrencyInputs();

    // Re-initialize after dynamic content changes (for forms loaded via AJAX, etc.)
    // You can call initializeCurrencyInputs() after adding new form elements

    // Expose function globally for manual initialization
    window.initializeCurrencyInputs = initializeCurrencyInputs;
});
