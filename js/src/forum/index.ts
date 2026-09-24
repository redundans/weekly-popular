import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import DiscussionListState from 'flarum/forum/states/DiscussionListState';
import type { SortMap } from 'flarum/common/states/PaginatedListState';

app.initializers.add('redundans-weekly-popular', () => {
  if ((app.data as Record<string, unknown>).weekly_popular_enabled === false) {
    return;
  }

  extend(DiscussionListState, 'sortMap', (sortMap: SortMap) => {
    return {
      ...sortMap,
      weeklyPopular: '-weeklyPopular',
    };
  });
});
