<?php
// app/Support/polyfills.php
// Temporary PHP 8 compatibility polyfills for legacy libraries.

if (!function_exists('get_magic_quotes_runtime')) {
    function get_magic_quotes_runtime()
    {
        return 0;
    }
}

if (!function_exists('set_magic_quotes_runtime')) {
    function set_magic_quotes_runtime($new_setting)
    {
        // No-op in PHP 7+; return false for compatibility
        return false;
    }
}
