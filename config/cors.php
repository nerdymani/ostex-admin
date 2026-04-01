<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['GET', 'POST'],
    'allowed_origins' => [
        'https://ostexs.com',
        'https://www.ostexs.com',
        'https://admin.ostexs.com',
        'https://e-office.ostexs.com',
        'http://localhost:8000',
        'http://localhost:8001',
        'http://localhost:8002',
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Content-Type', 'Accept', 'X-Requested-With'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
