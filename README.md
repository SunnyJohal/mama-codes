# Mama Codes

> Make Wordpress theme development great again.

## Features

- Modern JavaScript through Webpack
- Live reload via BrowserSync
- SCSS support
- Easy dev environments with Docker Compose
- Stateless, immutable plugin management via Composer
- Helpful HTML5 Router for firing JS based on Wordpress page slug.
- Nothing else.

## Requirements

- Node.js
- Yarn
- PHP and Composer
- Docker for Mac / Windows
- Docker Compose

## Getting Started

```bash
git clone git@github.com:jaredpalmer/presspack.git
yarn install
composer install # if you want plugins ( not required )
docker-compose up
```

## Developing Locally

To work on the theme locally, open another window/tab in terminal and run:

```bash
yarn start
```

This will open a browser, watch all files (php, scss, js, etc) and reload the
browser when you press save.

## Building for Production

To create an optimized production build, run:

```bash
yarn build
```

This will minify assets, bundle and uglify javascript, and compile scss to css.
It will also add cachebusting names to then ends of the compiled files, so you
do not need to bump any enqueued asset versions in `functions.php`.

## Changing ports

There are two ports involved, the port of the dockerized wordpress instance,
and the port the Browser Sync runs on. To change the port of the dockerized
wordpress instance go into [`docker-compose.yml`](docker-compose.yml#L25) and
modify `ports`.

```yml
# docker-compose.yml
 ...
  ports:
    - "9009:80" # only need to change `9009:80` --> localhost:9009
 ...
```

If you want to change the port you develop on (the default is 4000), then open
[`scripts/webpack.config.js`](scripts/webpack.config.js#L119) and modify
`BrowserSyncPlugin`'s `port` option. If you changed the wordpress port above,
be sure to also change `proxy` accordingly. Don't forget the trailing slash.

```js
// scripts/webpack.config.js
...
new BrowserSyncPlugin({
  notify: false,
  host: 'localhost',
  port: 4000, // this is the port you develop on. Can be anything.
  logLevel: 'silent',
  files: ['./*.php'],
  proxy: 'http://localhost:9009/', // This port must match docker-compose.yml
}),
...
```

## Project Structure

To genrate the tree after updating:

```bash
pwd=$(pwd)
find $pwd -print | sed -e "s;$pwd;\.;g;s;[^/]\*\/;|**;g;s;**|; |;g"
```

```bash
.
|__README.md
|__.gitignore
|__docker-compose.yml
|__src
| |__plugins
| | |__index.php
| | |__akismet
| | | |__class.akismet-cli.php
| | | |__class.akismet.php
| | | |__index.php
| | | |__class.akismet-widget.php
| | | |__class.akismet-admin.php
| | | |__class.akismet-rest-api.php
| | | |__readme.txt
| | | |___inc
| | | | |__akismet.js
| | | | |__img
| | | | | |__logo-full-2x.png
| | | | |__akismet.css
| | | | |__form.js
| | | |__wrapper.php
| | | |__akismet.php
| | | |__LICENSE.txt
| | | |__views
| | | | |__get.php
| | | | |__config.php
| | | | |__stats.php
| | | | |__notice.php
| | | | |__start.php
| | | |__.htaccess
| | |__hello.php
| |__uploads
| |__themes
| | |__twentyseventeen
| | | |__functions.php
| | | |__404.php
| | | |__inc
| | | | |__icon-functions.php
| | | | |__customizer.php
| | | | |__custom-header.php
| | | | |__color-patterns.php
| | | | |__template-tags.php
| | | | |__template-functions.php
| | | | |__back-compat.php
| | | |__index.php
| | | |__archive.php
| | | |__comments.php
| | | |__screenshot.png
| | | |__search.php
| | | |__header.php
| | | |__template-parts
| | | | |__footer
| | | | | |__footer-widgets.php
| | | | | |__site-info.php
| | | | |__page
| | | | | |__content-page.php
| | | | | |__content-front-page.php
| | | | | |__content-front-page-panels.php
| | | | |__post
| | | | | |__content-gallery.php
| | | | | |__content-none.php
| | | | | |__content-excerpt.php
| | | | | |__content.php
| | | | | |__content-audio.php
| | | | | |__content-video.php
| | | | | |__content-image.php
| | | | |__navigation
| | | | | |__navigation-top.php
| | | | |__header
| | | | | |__site-branding.php
| | | | | |__header-image.php
| | | |__footer.php
| | | |__style.css
| | | |__README.txt
| | | |__single.php
| | | |__page.php
| | | |__assets
| | | | |__css
| | | | | |__colors-dark.css
| | | | | |__ie9.css
| | | | | |__ie8.css
| | | | | |__editor-style.css
| | | | |__images
| | | | | |__coffee.jpg
| | | | | |__espresso.jpg
| | | | | |__header.jpg
| | | | | |__sandwich.jpg
| | | | | |__svg-icons.svg
| | | | |__js
| | | | | |__html5.js
| | | | | |__skip-link-focus-fix.js
| | | | | |__customize-preview.js
| | | | | |__global.js
| | | | | |__jquery.scrollTo.js
| | | | | |__navigation.js
| | | | | |__customize-controls.js
| | | |__rtl.css
| | | |__sidebar.php
| | | |__front-page.php
| | | |__searchform.php
| | |__twentysixteen
| | | |__functions.php
| | | |__404.php
| | | |__inc
| | | | |__customizer.php
| | | | |__template-tags.php
| | | | |__back-compat.php
| | | |__index.php
| | | |__archive.php
| | | |__genericons
| | | | |__COPYING.txt
| | | | |__Genericons.svg
| | | | |__genericons.css
| | | | |__README.md
| | | | |__Genericons.woff
| | | | |__Genericons.eot
| | | | |__LICENSE.txt
| | | | |__Genericons.ttf
| | | |__css
| | | | |__ie8.css
| | | | |__ie7.css
| | | | |__editor-style.css
| | | | |__ie.css
| | | |__js
| | | | |__html5.js
| | | | |__color-scheme-control.js
| | | | |__skip-link-focus-fix.js
| | | | |__functions.js
| | | | |__customize-preview.js
| | | | |__keyboard-image-navigation.js
| | | |__comments.php
| | | |__screenshot.png
| | | |__search.php
| | | |__sidebar-content-bottom.php
| | | |__header.php
| | | |__template-parts
| | | | |__content-single.php
| | | | |__biography.php
| | | | |__content-none.php
| | | | |__content-page.php
| | | | |__content.php
| | | | |__content-search.php
| | | |__footer.php
| | | |__style.css
| | | |__readme.txt
| | | |__single.php
| | | |__page.php
| | | |__rtl.css
| | | |__sidebar.php
| | | |__image.php
| | | |__searchform.php
| | |__twentyfifteen
| | | |__functions.php
| | | |__404.php
| | | |__inc
| | | | |__customizer.php
| | | | |__custom-header.php
| | | | |__template-tags.php
| | | | |__back-compat.php
| | | |__index.php
| | | |__archive.php
| | | |__genericons
| | | | |__COPYING.txt
| | | | |__Genericons.svg
| | | | |__genericons.css
| | | | |__README.md
| | | | |__Genericons.woff
| | | | |__Genericons.eot
| | | | |__LICENSE.txt
| | | | |__Genericons.ttf
| | | |__css
| | | | |__ie7.css
| | | | |__editor-style.css
| | | | |__ie.css
| | | |__js
| | | | |__html5.js
| | | | |__color-scheme-control.js
| | | | |__skip-link-focus-fix.js
| | | | |__functions.js
| | | | |__customize-preview.js
| | | | |__keyboard-image-navigation.js
| | | |__content-none.php
| | | |__comments.php
| | | |__content-page.php
| | | |__screenshot.png
| | | |__content.php
| | | |__search.php
| | | |__header.php
| | | |__content-search.php
| | | |__footer.php
| | | |__style.css
| | | |__content-link.php
| | | |__author-bio.php
| | | |__readme.txt
| | | |__single.php
| | | |__page.php
| | | |__rtl.css
| | | |__sidebar.php
| | | |__image.php
| | |__index.php
| | |__mama-codes
| | | |__functions.php
| | | |__.babelrc
| | | |__composer.lock
| | | |__index.php
| | | |__yarn.lock
| | | |__header.php
| | | |__package.json
| | | |__scripts
| | | | |__start.js
| | | | |__build.js
| | | | |__webpack.config.js
| | | |__footer.php
| | | |__style.css
| | | |__page.php
| | | |__composer.json
| | | |__src
| | | | |__util
| | | | | |__Router.js
| | | | | |__camelCase.js
| | | | |__index.js
| | | | |__styles
| | | | | |___global-vars.scss
| | | | | |___base.scss
| | | | |__style.scss
| | | | |__routes
| | | | | |__home.js
| | | | | |__common.js
| |__uploads.ini
```

#### Author

- Virginia Dooley
- Sunny Johal
