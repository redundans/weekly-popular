## Building the JavaScript

From the extension root:

```bash
cd js
npm install
npm run build
```

The build creates `js/dist/forum.js`, `js/dist/admin.js`, and their source maps. Those generated files are required by `extend.php` at runtime.

For development with automatic rebuilds:

```bash
npm run dev
```

Use Node.js 18 or newer. If npm reports a missing `webpack` or `webpack-cli` command, remove the old install and reinstall dependencies:

```bash
rm -rf node_modules package-lock.json
npm install
npm run build
```
