<?php

namespace Redundans\WeeklyPopular\Search;

use Carbon\Carbon;
use Flarum\Post\Post;
use Flarum\Search\Database\DatabaseSearchState;
use Flarum\Search\SearchCriteria;

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

        $search->getQuery()
            ->reorder()
            ->selectSub($recentComments, 'weekly_popular_score')
            ->orderByDesc('weekly_popular_score');
    }

    private function usesWeeklyPopular(?array $sort): bool
    {
        foreach ($sort ?? [] as $field => $direction) {
            if (in_array($field, ['weeklyPopular', 'weekly_popular'], true)) {
                return true;
            }
        }

        return false;
    }
}
