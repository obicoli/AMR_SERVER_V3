<?php

return [

    /*
     * Is email activation required
     */
    'activation' => env('ACTIVATION', false),

    /*
     * Is email activation required
     */
    'timePeriod' => env('ACTIVATION_LIMIT_TIME_PERIOD', 24),

    'otpResendTrial' => env('OTP_LIMIT_RESEND', 3),

    /*
     * Is email activation required
     */
    'maxAttempts' => env('ACTIVATION_LIMIT_MAX_ATTEMPTS', 2000),

    /*
     * NULL Ip to enter to match database schema
     */
    'nullIpAddress' => env('NULL_IP_ADDRESS', '0.0.0.0'),

    /*
     * User restore encryption type
     */
    'restoreUserEncType' => 'AES-256-ECB',

    /*
     * User restore days past cutoff
     */
    'restoreUserCutoff' => env('USER_RESTORE_CUTOFF_DAYS', 31),

    /*
     * User restore encryption key
     */
    'restoreKey' => env('USER_RESTORE_ENCRYPTION_KEY', 'sup3rS3cr3tR35t0r3K3y21!'),

    /*
     * ReCaptcha Status
     */
    'reCaptchStatus' => env('ENABLE_RECAPTCHA', false),

    /*
     * Google Maps API V3 Status
     */
    'googleMapsAPIStatus' => env('GOOGLEMAPS_API_STATUS', false),

    'default_avatar' => '/assets/images/profile/avatar.jpg',

    'application' => [
        'name' => 'AMREF Enterprises | AMREF Health Africa',
        'domain' => 'https://portal.afyamkononi.com',
        //'client' => 'http://localhost:8000',
        'client' => 'https://amref.afyatele.com',
        'doctor_domain' => 'https://clinic.afyamkononi.com',
        //'doctor_domain' => 'http://192.168.1.241:10000/',
        'patient_domain' => 'https://dashboard.afyamkononi.com',
        'manufacturer_domain' => 'https://store.afyamkononi.com',
        'logo' => '/img/logo/logo.png',
        'address' => 'KMA Center, Mara Road PO. BOX 55690-00200',
        'email' => 'info@afyamkononi.com',
        'description' => '',
    ]

];
