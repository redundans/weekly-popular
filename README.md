# Weekly Popular

A Flarum 2.0 extension that adds a server-side discussion sort for comments created during a configurable recent window.

## Build

```bash
cd js
npm install
npm run build
```

## Implementation

The `weekly-popular` API sort is implemented in PHP. It counts recent comment posts in a correlated SQL subquery and applies the ordering before pagination. This avoids the previous client-side implementation, which could only reorder the discussions already present on the current page.

After changing the PHP code or settings, clear Flarum's cache:

```bash
php flarum cache:clear
```
