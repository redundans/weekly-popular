# Weekly Popular

A Flarum 2.0 extension that adds a discussion sort for content with the strongest comment activity over the last seven days, inspired by Reddit’s "popular" feed.

## Features

- Adds a custom forum sort named "Popular (7d)"
- Ranks discussions by recent activity in a configurable time window
- Allows the admin to toggle the feature on or off
- Lets the admin set the window in days
- Lets the admin change the visible sort label

## Installation

```bash
composer require redundans/weekly-popular
php flarum cache:clear
```

Then enable the extension in the Flarum admin panel.

## How it works

The extension exposes a custom discussion sort option in the forum and reorders the loaded discussions client-side based on:

- comment count
- how recently the discussion was active
- the configured timeframe window

This creates a simple Reddit-like "popular this week" experience without needing a full custom front page.

## Notes

This is a practical forum-side implementation for Flarum 2.0. It is fast and easy to configure, and it works well for community discussion lists. If you need a stricter backend ranking model or a server-side "popular in last N days" query for larger communities, a custom repository query or computed database field would be the next step.
