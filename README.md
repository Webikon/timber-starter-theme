# Timber Starter Theme (Webikon version)

This theme uses Timber framework.
Also includes Gulp workflow, basic dotfiles and Foundation 6.


## Working with the Theme

### Installing

1. Download the zip for this theme (or clone it) and move it to `wp-content/themes` in your WordPress installation.
2. Rename the folder to something that makes sense for you website. It should be a short name with no spaces - underscores and hyphens are okay - and all lowercase.
3. Activate the theme in Appearance >  Themes.
4. If you would see a notice that Timber needs to be downloaded: see step 3. in `To get started` section
5. Set a static home page in Settings > Reading and choosing "A Static Page". This will automatically act as your home page and will reference the `views/front-page.twig` template.
6. Make sure you have installed the plugin Advanced Custom Fields PRO or other CF plugin.

### Getting Started

You'll need:

- NPM or Yarn
- SASS
- Composer
- linters

To get started:

1. Clone this repo to your WordPress themes directory
2. Run `$ yarn install` or `$ npm install` to download dependencies
2. Run `$ composer install` to download Timber
3. Adjust the Foundation variables file in `assets/scss/_settings.scss` to your needs
4. Set your localhost dev domain in `gulpfile.js` for BrowserSync to work
5. Select which Foundation js plugins and utils you wish to use in `gulpfile.js`

To replace the default `wbkn` prefixes:

1. Search for `'wbkn'` (inside single quotations) to capture the text domain
2. Search for `wbkn_` to capture all the function names
3. Search for `Text Domain: wbkn` in style.css
4. Search for `wbkn-` to capture prefixed handles
6. Change `Theme Name` and `Description` in style.css

To generate assets:

- run the default gulp task (`gulp`) to generate development files. they are not prefixed or minified and contain source maps
- run `gulp build` to generate files used in production. minified, autoprefixed and everything
- development/production assets are loaded based on the `WP_DEBUG` constant defined in `wp-config.php`

Text Editor requirements:
To help maintain coding styles and standards between different editors and developers, you need to
install and configure several packages:

- `editorconfig`: https://github.com/sindresorhus/atom-editorconfig or https://github.com/sindresorhus/editorconfig-sublime
- `scss lint`: https://atom.io/packages/linter-scss-lint or https://packagecontrol.io/packages/SublimeLinter-contrib-scss-lint
- `eslint`: https://atom.io/packages/linter-eslint or https://packagecontrol.io/packages/SublimeLinter-contrib-eslint
- `phpcs`: https://atom.io/packages/linter-phpcs or https://packagecontrol.io/packages/Phpcs. Use `Wordpress-Core` standards. How to use WPCS: https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards#how-to-use

## Structure

`assets/` contains static front-end files and images. In other words, your Sass files, JS files, SVGs, or any PNGs would live here.

`acf-json/` contains JSON files for tracking Advanced Custom Fields. This is incredibly useful for version control. After cloning this repository, you can go into Custom Fields from the Dashboard and select "Sync" to import these custom fields into your theme.

`lib/` contains custom functionality and files for custom post type, taxonomies, widgets. These are added to WordPress inside functions.php and could be included there, but are separated into other files to keep functions.php a bit cleaner.

`views/` contains all of your Twig templates. These correspond 1 to 1 with the PHP files that make the data available to the Twig templates.

`views/partials` contains Twig components

Example:
`front-page.php` and `views/front-page.twig` are templates for a static home page should you choose to use one. This template will automatically be applied to that page whatever its name may be.


This theme is heavily inspired by Timber Starter Theme (thx to Upstatement and Lara) and underscores (thx to Automattic).

Enjoy!
