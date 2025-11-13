<?php

return [
    // Only these order statuses are counted as sales
    'paid_statuses' => ['Paid', 'Completed'],

    // Local timezone for quarter math and display
    'timezone' => 'Africa/Johannesburg',

    // Default royalty rate (%) if a product has no specific rate set
    'default_royalty_rate' => 35.0,

    // Optional netting (set to 0 if you don’t want to subtract anything)
    'platform_fee_rate' => 0.0,  // percent of gross revenue per line
    'vat_rate'          => 0.0,  // percent; shown for info if you enable it later
];
