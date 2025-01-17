<?php

return [
    'url' => env('OPCACHE_URL', config('app.url')),
    'prefix' => 'opcache-api',
    'verify' => true,
    'headers' => [],
    'directories' => [
        base_path('app'),
        base_path('bootstrap'),
        base_path('public'),
        base_path('resources'),
        base_path('routes'),
        base_path('storage'),
        base_path('vendor'),

    ],
    'exclude' => [
        'test',
        'Test',
        'tests',
        'Tests',
        'stub',
        'Stub',
        'stubs',
        'Stubs',
        'dumper',
        'Dumper',
        'Autoload',
        'symfony/console',
        'symfony/event-dispatcher',
        'symfony/polyfill-ctype',
        'symfony/polyfill-iconv',
        'symfony/polyfill-intl-grapheme',
        'symfony/polyfill-intl-idn',
        'symfony/polyfill-intl-normalizer',
        'symfony/polyfill-mbstring',
        'symfony/polyfill-php80'
    ],
];
