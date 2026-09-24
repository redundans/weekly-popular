<?php

use Flarum\Api\Resource;
use Flarum\Discussion\Search\DiscussionSearcher;
use Flarum\Extend;
use Flarum\Search\Database\DatabaseSearchDriver;
use Redundans\WeeklyPopular\Api\Sort\WeeklyPopularSort;
use Redundans\WeeklyPopular\Search\WeeklyPopularSearchMutator;

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
        ->sorts(fn () => [
            WeeklyPopularSort::make('weeklyPopular')
                ->descendingAlias('weekly-popular'),
        ]),

    (new Extend\SearchDriver(DatabaseSearchDriver::class))
        ->addMutator(DiscussionSearcher::class, WeeklyPopularSearchMutator::class),
];
