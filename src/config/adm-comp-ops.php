<?php

return [
    'sender' => [
        'host' => env('ADM_COMP_OPS_MAIL_HOST', 'smtp.gmail.com'),
        'port' => env('ADM_COMP_OPS_MAIL_PORT', '587'),
        'username' => env('ADM_COMP_OPS_MAIL_USERNAME', '4alabsenes@gmail.com'),
        'password' => env('ADM_COMP_OPS_MAIL_PASSWORD', 'xxcx pbcz fggu douf'),
        'encryption' => env('ADM_COMP_OPS_MAIL_ENCRYPTION', 'tls'),
        'from_email' => env('ADM_COMP_OPS_MAIL_FROM_ADDRESS', '4alabsenes@gmail.com'),
        'from_name' => env('ADM_COMP_OPS_MAIL_FROM_NAME', 'Enes Poyraz'),
    ],
    'emails' => [
        'enes.poyraz@4alabs.io'
    ],
];
