<?php

namespace Redundans\WeeklyPopular\Api\Sort;

use Carbon\Carbon;
use Flarum\Post\Post;
use Illuminate\Database\Eloquent\Builder;
use Tobyz\JsonApiServer\Context;
use Tobyz\JsonApiServer\Schema\Sort;

/**
 * Sort discussions by the number of comment posts created recently.
 *
 * Unlike SortColumn, this sort is computed from a SQL subquery rather than
 * treated as a physical discussions-table column.
 */
class WeeklyPopularSort extends Sort
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
