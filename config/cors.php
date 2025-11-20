<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout', 'register', 'admin/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'https://frontend-production-c996.up.railway.app',
        'https://pitychick-production.up.railway.app',
        'http://localhost:3000',
        'http://localhost:5173'
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Set false dulu
];