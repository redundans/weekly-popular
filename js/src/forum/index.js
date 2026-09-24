import app from 'flarum/forum/app';
import { extend } from 'flarum/extend';
import DiscussionListState from 'flarum/forum/states/DiscussionListState';

app.initializers.add('redundans-weekly-popular', () => {
  if (app.data.weekly_popular_enabled === false) {
    return;
  }

  extend(DiscussionListState.prototype, 'sortMap', function (sortMap) {
    sortMap.weeklyPopular = '-weeklyPopular';

    return sortMap;
  });
});
