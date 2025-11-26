<?php

if (! function_exists('formatCurrencyVND')) {
    /**
     * Format currency to Vietnamese Dong format
     *
     * @param  float|int  $amount
     * @return string
     */
    function formatCurrencyVND($amount)
    {
        return number_format($amount, 0, ',', '.').' VND';
    }
}

if (! function_exists('formatCurrencyVNDNoSymbol')) {
    /**
     * Format currency to Vietnamese Dong format without VND symbol
     *
     * @param  float|int  $amount
     * @return string
     */
    function formatCurrencyVNDNoSymbol($amount)
    {
        return number_format($amount, 0, ',', '.');
    }
}

if (! function_exists('parseCurrencyVND')) {
    /**
     * Parse VND formatted string back to number
     *
     * @param  string  $formattedAmount
     * @return float
     */
    function parseCurrencyVND($formattedAmount)
    {
        // Remove VND and spaces, replace dots with empty string
        $cleaned = str_replace([' VND', ' ', '.'], ['', '', ''], $formattedAmount);

        return (float) $cleaned;
    }
}
