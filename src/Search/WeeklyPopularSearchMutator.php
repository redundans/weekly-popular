<?php

namespace Redundans\WeeklyPopular\Search;

use Carbon\Carbon;
use Flarum\Discussion\Search\DiscussionSearcher;
use Flarum\Post\Post;
use Flarum\Search\Database\DatabaseSearchState;
use Flarum\Search\SearchCriteria;

/**
 * Replaces Flarum's normal column sort when the discussion searcher handles
 * the API request. Discussion index requests are executed through the search
 * driver, which otherwise converts weeklyPopular to weekly_popular and sends
 * it to ORDER BY as a database column.
 */
final class WeeklyPopularSearchMutator
{
    public function __invoke(DatabaseSearchState $search, SearchCriteria $criteria): void
    {
        if (! $this->usesWeeklyPopular($criteria->sort)) {
            return;
        }

        $days = (int) resolve('flarum.settings')->get('weekly_popular_timeframe', 7);
        $days = max(1, min($days, 30));

        $recentComments = Post::query()
            ->selectRaw('COUNT(*)')
            ->whereColumn('posts.discussion_id', 'discussions.id')
            ->where('posts.type', 'comment')
            ->where('posts.created_at', '>=', Carbon::now()->subDays($days));

        // The searcher has already applied the requested column order. Replace
        // it with the computed score before the query is executed.
        $search->getQuery()->reorder()
            ->selectSub($recentComments, 'weekly_popular_score')
            ->orderByDesc('weekly_popular_score');
    }

    private function usesWeeklyPopular(?array $sort): bool
    {
        foreach ($sort ?? [] as $field => $direction) {
            if ($field === 'weeklyPopular' || $field === 'weekly_popular') {
                return true;
            }
        }

        return false;
    }
}
