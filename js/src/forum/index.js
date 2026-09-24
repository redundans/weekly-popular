import app from 'flarum/forum/app';
import { extend } from 'flarum/extend';
import DiscussionList from 'flarum/components/DiscussionList';

const SORT_KEY = 'weekly-popular';

function getDaysInMs(days) {
  return days * 24 * 60 * 60 * 1000;
}

function getScore(discussion, timeframeDays = 7) {
  const attributes = discussion && discussion.attributes ? discussion.attributes : {};
  const lastPostedAt = attributes.lastPostedAt || attributes.lastPostedAtDate;
  const commentCount = Number(attributes.commentCount || 0);

  if (!lastPostedAt) {
    return 0;
  }

  const ageInMs = Date.now() - new Date(lastPostedAt).getTime();
  const cutoff = getDaysInMs(timeframeDays);

  if (ageInMs > cutoff) {
    return 0;
  }

  return commentCount;
}

app.initializers.add('redundans-weekly-popular', () => {
  const sortLabel = app.data['weekly_popular_label'] || app.translator.trans('redundans-weekly-popular.forum.sort_popular');
  const enabled = app.data['weekly_popular_enabled'] !== false;
  const timeframe = Number(app.data['weekly_popular_timeframe'] || 7);

  if (!enabled) {
    return;
  }

  const sortMap = app.discussionList && app.discussionList.sortMap ? app.discussionList.sortMap : {};
  sortMap[SORT_KEY] = sortLabel;
  app.discussionList.sortMap = sortMap;

  extend(DiscussionList.prototype, 'oninit', function () {
    if (!this.params) return;

    const current = this.params().sort;
    if (current === SORT_KEY) {
      this.params = () => ({ ...this.params(), sort: SORT_KEY });
    }
  });

  extend(DiscussionList.prototype, 'view', function (vdom) {
    if (!this.props || !this.props.discussions || !Array.isArray(this.props.discussions)) {
      return;
    }

    const params = this.params ? this.params() : {};
    if (!params || params.sort !== SORT_KEY) {
      return;
    }

    const list = [...this.props.discussions].sort((a, b) => {
      return getScore(b, timeframe) - getScore(a, timeframe);
    });

    this.props.discussions = list;
  });
});
