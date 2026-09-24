import app from 'flarum/forum/app';
import { extend } from 'flarum/extend';
import DiscussionList from 'flarum/components/DiscussionList';

const SORT_KEY = 'weekly-popular';

function getTimeframeDays() {
  const rawValue = Number(app.data['weekly_popular_timeframe']);

  if (!Number.isFinite(rawValue) || rawValue <= 0) {
    return 7;
  }

  return Math.min(rawValue, 30);
}

function getLastPostedAt(discussion) {
  const attributes = discussion && discussion.attributes ? discussion.attributes : {};

  return attributes.lastPostedAt || attributes.lastPostedAtDate || attributes.createdAt || null;
}

function scoreDiscussion(discussion, timeframeDays) {
  const attributes = discussion && discussion.attributes ? discussion.attributes : {};
  const lastPostedAt = getLastPostedAt(discussion);

  if (!lastPostedAt) {
    return 0;
  }

  const ageInMs = Date.now() - new Date(lastPostedAt).getTime();
  const ageInDays = ageInMs / 86400000;

  if (ageInDays > timeframeDays) {
    return 0;
  }

  const commentCount = Number(attributes.commentCount || 0);
  const recencyWeight = 1 + (1 - Math.min(ageInDays / timeframeDays, 1)) * 2;

  return commentCount * recencyWeight;
}

app.initializers.add('redundans-weekly-popular', () => {
  const enabled = app.data['weekly_popular_enabled'] !== false;

  if (!enabled) {
    return;
  }

  const label = app.data['weekly_popular_label'] || app.translator.trans('redundans-weekly-popular.forum.sort_popular');
  const sortMap = app.discussionList && app.discussionList.sortMap ? app.discussionList.sortMap : {};

  sortMap[SORT_KEY] = label;
  app.discussionList.sortMap = sortMap;

  extend(DiscussionList.prototype, 'view', function () {
    if (!this.props || !Array.isArray(this.props.discussions)) {
      return;
    }

    const params = this.params ? this.params() : {};
    if (!params || params.sort !== SORT_KEY) {
      return;
    }

    const timeframeDays = getTimeframeDays();

    this.props.discussions = [...this.props.discussions].sort((a, b) => {
      const scoreA = scoreDiscussion(a, timeframeDays);
      const scoreB = scoreDiscussion(b, timeframeDays);

      if (scoreB === scoreA) {
        return Number((b.attributes && b.attributes.commentCount) || 0) - Number((a.attributes && a.attributes.commentCount) || 0);
      }

      return scoreB - scoreA;
    });
  });
});
