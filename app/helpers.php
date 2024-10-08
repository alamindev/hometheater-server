<?php 

if (!function_exists('formatPrice')) {
    function formatPrice($price, $currency = 'USD', $locale = 'en_US') {
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($price, $currency);
    }
}