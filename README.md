# Weekly Popular

A Flarum 2.0 extension that adds a discussion sort for posts with the strongest activity in the last 7 days, inspired by Reddit’s front page "popular" feed.

## Features

- Adds a forum sort option named "Popular (7d)"
- Weights discussions by recent comments within the selected timeframe
- Admin setting for enabling/disabling the sort
- Admin setting for the time window in days
- Admin setting for customizing the visible sort label
- Designed to work with Flarum 2.0

## Installation

```bash
composer require redundans/weekly-popular
php flarum cache:clear
```

Then enable the extension from the Flarum admin panel.

## Configuration

Available settings:

- `weekly_popular_enabled` — enable or disable the custom sort
- `weekly_popular_timeframe` — number of days to measure activity over
- `weekly_popular_label` — the label shown in the sort menu

## Intended behavior

The sort ranks discussions by activity within the selected window, prioritizing those with more comments created recently. This creates a Reddit-like "active this week" feed without requiring a full custom front page implementation.

## Notes

This extension is intentionally lightweight and works as a forum-level sorting helper. If you want a stronger, server-side ranking model for very large communities, the next step would be to add a dedicated database column and a generated ranking score for each discussion.
