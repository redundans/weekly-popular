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

## Build JavaScript assets

The repository does not commit generated JavaScript assets. Build them before installing the extension from a checkout:

```bash
cd js
npm install
npm run build
```

See [`js/README.md`](js/README.md) for troubleshooting.

## How it works

The extension exposes a custom discussion sort option in the forum and reorders the loaded discussions based on comment count and recency within the configured timeframe.
