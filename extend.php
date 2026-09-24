<?php

use Flarum\Api\Resource;
use Flarum\Extend;
use Redundans\WeeklyPopular\Api\Sort\WeeklyPopularSort;

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    new Extend\Locales(__DIR__ . '/locale'),

    (new Extend\Settings())
        ->default('weekly_popular_enabled', true)
        ->default('weekly_popular_timeframe', 7)
        ->default('weekly_popular_label', 'Popular (7d)')
        ->serializeToForum('weekly_popular_enabled', 'weekly_popular_enabled', 'boolval')
        ->serializeToForum('weekly_popular_timeframe', 'weekly_popular_timeframe', 'intval')
        ->serializeToForum('weekly_popular_label', 'weekly_popular_label'),

    (new Extend\ApiResource(Resource\DiscussionResource::class))
        ->sorts(fn () => [WeeklyPopularSort::make()]),
];
