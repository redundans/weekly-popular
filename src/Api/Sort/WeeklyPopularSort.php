<?php

namespace Redundans\WeeklyPopular\Api\Sort;

use Carbon\Carbon;
use Flarum\Post\Post;
use Illuminate\Database\Eloquent\Builder;
use Tobyz\JsonApiServer\Context;
use Tobyz\JsonApiServer\Laravel\Sort\Sort;

/**
 * Sort discussions by the number of comment posts created recently.
 *
 * The score is calculated in SQL before pagination, so the API returns the
 * correct discussions on every page instead of sorting only the 20 records
 * already loaded in the browser.
 */
class WeeklyPopularSort extends Sort
{
    public static function make(): static
    {
        return new static('weeklyPopular');
    }

    public function apply(object $query, string $direction, Context $context): void
    {
        /** @var Builder $query */
        $days = (int) resolve('flarum.settings')->get('weekly_popular_timeframe', 7);
        $days = max(1, min($days, 30));

        $recentComments = Post::query()
            ->selectRaw('COUNT(*)')
            ->whereColumn('posts.discussion_id', 'discussions.id')
            ->where('posts.type', 'comment')
            ->where('posts.created_at', '>=', Carbon::now()->subDays($days));

        $query
            ->selectSub($recentComments, 'weekly_popular_score')
            ->orderBy('weekly_popular_score', $direction === 'asc' ? 'asc' : 'desc')
            ->orderByDesc('discussions.last_posted_at');
    }

    public function sortMap(): array
    {
        return ['weekly-popular' => '-weeklyPopular'];
    }
}
