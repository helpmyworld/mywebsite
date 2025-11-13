<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    */
    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Set MAIL_TLS_RELAX=true in .env for local/dev only.
    | In production, keep it false (or omit) so TLS verification is enforced.
    |
    */
    'mailers' => [

        'smtp' => [
            'transport'    => 'smtp',
            'host'         => env('MAIL_HOST', '66.29.130.230'),
            'port'         => env('MAIL_PORT', 587),
            'encryption'   => env('MAIL_ENCRYPTION', 'tls'),
            'username'     => env('MAIL_USERNAME', 'info@helpmyworld.co.za'),
            'password'     => env('MAIL_PASSWORD', '2DJk*S,3A6bO'),
            'timeout'      => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN'),

            // Relax TLS only if MAIL_TLS_RELAX=true (use for local/dev ONLY)
            'stream' => env('MAIL_TLS_RELAX', false) ? [
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                ],
            ] : [],
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'mailgun' => [
            'transport' => 'mailgun',
        ],

        'postmark' => [
            'transport' => 'postmark',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path'      => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs'),
        ],

        'log' => [
            'transport' => 'log',
            'channel'   => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    */
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'info@helpmyworld.co.za'),
        'name'    => env('MAIL_FROM_NAME', 'Helpmyworld Publishing'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    */
    'markdown' => [
        'theme' => 'default',
        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],
];
