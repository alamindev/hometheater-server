<?php 

if (!function_exists('formatPrice')) {
    function formatPrice($price) { 
        if (strpos($price, '.') !== false) {
            // If the price has decimal places
            $formattedPrice = rtrim(rtrim($price, '0'), '.'); // Trim trailing zeros and dot
        } else {
            // If the price is a whole number
            $formattedPrice = $price;
        }
        
        return $formattedPrice;
    }
}