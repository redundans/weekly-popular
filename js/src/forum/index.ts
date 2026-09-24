import app from 'flarum/forum/app';
import { override, extend } from 'flarum/common/extend';
import DiscussionListState from 'flarum/forum/states/DiscussionListState';
import type { SortMap } from 'flarum/common/states/PaginatedListState';

app.initializers.add('redundans-weekly-popular', () => {
  if ((app.data as Record<string, unknown>).weekly_popular_enabled === false) {
    return;
  }

  override(DiscussionListState.prototype, 'sortMap', function(original) {
    const map = original();
    delete map.top;
    delete map.za;
    delete map.az;
    delete map.oldest;
    return map;
  });

  extend('flarum/forum/states/DiscussionListState', 'sortMap', function (this: any, map: any) {
    map.weeklyPopular = '-weeklyPopular';
  });
});
