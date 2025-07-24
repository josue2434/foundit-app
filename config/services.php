<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */



    'external_api' => [
        'base_url' => env('EXTERNAL_API_BASE_URL', 'http://98.71.33.93:3000'),
        'timeout' => env('EXTERNAL_API_TIMEOUT', 30),
    ],


];
