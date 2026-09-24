## Building the JavaScript

From the extension root:

```bash
cd js
npm install
npm run build
```

The entrypoints are `forum.js` and `admin.js`. The build creates `js/dist/forum.js` and `js/dist/admin.js`, which are loaded by `extend.php`.

For development with automatic rebuilds:

```bash
npm run dev
```

Use Node.js 18 or newer. If npm reports a missing command, reinstall dependencies:

```bash
rm -rf node_modules package-lock.json
npm install
npm run build
```
