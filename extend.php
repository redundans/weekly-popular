<?php

use Flarum\Extend;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js')
        ->css(__DIR__ . '/js/dist/forum.css'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js')
        ->css(__DIR__ . '/js/dist/admin.css'),

    (new Extend\Locales(__DIR__ . '/locale')),

    new Extend\Settings()
        ->serializeToForum('weekly_popular_enabled', 'weekly_popular_enabled')
        ->serializeToForum('weekly_popular_timeframe', 'weekly_popular_timeframe')
        ->serializeToForum('weekly_popular_label', 'weekly_popular_label'),
];
