<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
define('Site_URL','http://localhost:8000/');

//require __DIR__  . '/../../../../vendor/PayPal-PHP-SDK/autoload.php';
//require __DIR__.'/../../../../vendor/vendor/autoload.php';
/*
$paypal = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AQ0qnap_pDqFHoOJKvUlARDRI8J-otpu4tLObxc4vrEIw3ZpQQMGlyYFK0_lX4Bmfo2noLBqO8KQ9EdM',     // ClientID
        'EPkGZntINd1RNsuI8V2stET3BgGUxWnH6kUrpP5zAt6RRAXMa8qhBY_0OXSjixXdMCvauVPX7D5kU7b0'      // ClientSecret
    )
);


$paypal->setConfig(
        array(
            'mode' => 'sandbox',         //sandbox or live
            'log.LogEnabled' => true,
            'log.FileName' => '../PayPal.log',
            'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS or 'DEBUG' in sandbox
            'cache.enabled' => true,
            // 'http.CURLOPT_CONNECTTIMEOUT' => 30
            // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
            //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
        )
    );

*/



$paypal = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'Ae9DG-A5jqD9XvRhyoi2pSMPMDbpsfRbf9wyOste94J-QJEHpX5aZlaRYNsVZjcYbqsWtf-J0AEtUewh',     // ClientID
        'EG-jruFXVOHef7MKTUe6R8a10VlsnA4mFdwMd1-TkoOVmdomw3HHfLhCc7YU6M1wZSf8yUG4LGiG2RSi'      // ClientSecret
    )
);


$paypal->setConfig(
    array(
        'mode' => 'sandbox',         //sandbox or live
        'log.LogEnabled' => true,
        'log.FileName' => '../PayPal.log',
        'log.LogLevel' => 'INFO', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS or 'DEBUG' in sandbox
        'cache.enabled' => true,
        // 'http.CURLOPT_CONNECTTIMEOUT' => 30
        // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
        //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
    )
);
