<?php

namespace Redundans\WeeklyPopular\Api\Sort;

use Carbon\Carbon;
use Flarum\Api\Sort\SortColumn;
use Flarum\Post\Post;
use Illuminate\Database\Eloquent\Builder;
use Tobyz\JsonApiServer\Context;

/**
 * Sort discussions by the number of comment posts created recently.
 *
 * The score is calculated in SQL before pagination, so the API returns the
 * correct discussions on every page instead of sorting only the records
 * already loaded in the browser.
 */
class WeeklyPopularSort extends SortColumn
{
    public static function make(string $name): static
    {
        return new static($name);
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
}
