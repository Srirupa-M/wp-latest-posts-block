WP Latest Posts Block : 
A custom Gutenberg Block that dynamically displays WordPress Posts using server-side rendering and WP_Query. Built using modern Block Development practices.

1. Features :
(a) Dynamic Gutenberg Block
(b) Server-side Rendering (render.php)
(c) WP_Query integration
(d) Featured Images
(e) Category Badge
(f) Author
(g) Publish Date
(h) Responsive Grid
(i) Custom Block Controls
(j) Modern Card UI

2. Technologies Used :
(a) WordPress
(b) Gutenberg Blocks
(c) React
(d) JSX
(e) PHP
(f) WP_Query
(g) block.json
(h) @wordpress/scripts
(i) CSS Grid

3. Folder Structure :
WP Latest Posts Block/
|--build/
| |---block.json
| |---index-rtl.css
| |---index.asset.php
| |---index.css
| |---index.js
| |---render.php
| |---style-index-rtl.css
| |---style-index.css
|
|--includes/
| |---enqueue.php
|
|--screenshots/
| |---editor.png
| |---frontend.png
| |---Hover Effect.mp4
| |---mobile.png
|
|--src/
| |---block.json
| |---edit.css
| |---editor.css
| |---index.js
| |---render.php
| |---save.js
| |---style.css
|
|--package-lock.json
|--package.json
|--uninstall.php
|--README.md
|--wp-latest-posts-block.php

4. Installation :
(i) Copy plugin into wp-content/plugins/
(ii) Run : npm install
           npm run build
(iii) Activate Plugin
(iv) Insert "WP Latest Posts" block to any post/page.
