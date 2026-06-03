<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Public Website Domain
    |--------------------------------------------------------------------------
    |
    | The domain that serves the public-facing website. In production this
    | would be the main domain (e.g. bgbr.rw). In local dev it defaults
    | to localhost.
    |
    */
    'public_domain' => env('APP_PUBLIC_DOMAIN', 'localhost'),

    /*
    |--------------------------------------------------------------------------
    | System (Admin Portal) Domain
    |--------------------------------------------------------------------------
    |
    | The subdomain for the internal management system. In production this
    | would be something like portal.bgbr.rw.
    |
    */
    'system_domain' => env('APP_SYSTEM_DOMAIN', 'portal.localhost'),

    /*
    |--------------------------------------------------------------------------
    | Contact Form Settings
    |--------------------------------------------------------------------------
    */
    'contact_email' => env('CONTACT_FORM_RECIPIENT', 'info@bgbr.rw'),
    'contact_name'  => env('CONTACT_FORM_RECIPIENT_NAME', 'BGBR Staff'),
];
