<?php

return [
    'name' => 'LaravelPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'PWA',
        'start_url' => '/',
        'background_color' => '#09090B',
        'theme_color' => '#09090B',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => '#0B0B0D',
        'icons' => [
            '180x180' => [
                'path' => '/apple-touch-icon.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/favicon-96x96.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/web-app-manifest-192x192.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/web-app-manifest-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'shortcuts' => [
            [
                'name' => 'Shortcut Link 1',
                'description' => 'Shortcut Link 1 Description',
                'url' => '/shortcutlink1',
                'icons' => [
                    "src" => "/ifavicon-96x96.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Shortcut Link 2',
                'description' => 'Shortcut Link 2 Description',
                'url' => '/shortcutlink2'
            ]
        ],
        'custom' => []
    ]
];
