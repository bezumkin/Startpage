# Startpage

Simple web start page that allows you to start your day with a favorite links.

This package was made for https://webstartpage.ru and shows how we build sites with MODX in Russia.

**Do not install this on a production site**

## Install

1. Install the latest:
 * PdoTools
 * HybridAuth
2. Set up at least one social service to login.

Then you can work with sources or just install transport package

### Package
3. Upload and install transport package `startpage-1.0.0-pl.transport.zip`.
4. Get the API key from https://www.screenshotmachine.com, and specify it in the `sp_api_key` system setting.

### Sources 
3. Create directories
```
mkdir ~/www/Extras && mkdir ~/www/Extras/Startpage
mkdir ~/www/Extras/Startpage/assets && mkdir ~/www/Extras/Startpage/core
mkdir ~/www/Extras/Startpage/assets/components && mkdir ~/www/Extras/Startpage/core/components

mkdir ~/www/assets/components/startpage && mkdir ~/www/core/components/startpage
```
4. Make symlinks
```
ln -s ~/www/assets/components/startpage ~/www/Extras/Startpage/assets/components/
ln -s ~/www/core/components/startpage ~/www/Extras/Startpage/core/components/startpage
```
5. Upload sources into the `Extras` directory in the root of new website
6. Install package by running `http://yoursite.com/Extras/Startpage/_build/build.transport.php`
7. Get the API key from https://www.screenshotmachine.com, and specify it in the `sp_api_key` system setting.

## Scripts and styles

All assets sources are in the `_build/assets` directory. 
If you are using `sources` install, you can edit them and compile with **Gulp**.

Install libs
`npm install --prefix ~/www/Extras/Startpage/_build/`

Copy libs into site root
`gulp copy --gulpfile ~/www/Extras/Startpage/_build/gulpfile.js`

Single compile
`gulp --gulpfile ~/www/Extras/Startpage/_build/gulpfile.js`

Watch for changes
`gulp watch --gulpfile ~/www/Extras/Startpage/_build/gulpfile.js`

## PhpStorm setup
You must upload all files into `~/www/Extras/Startpage` directory.

[![](https://file.modx.pro/files/4/3/4/4349fd897855ecc771fc77770e3f9a80s.jpg)](https://file.modx.pro/files/4/3/4/4349fd897855ecc771fc77770e3f9a80.png)

[![](https://file.modx.pro/files/1/e/a/1ea6b3eae431ab23f9a005d9a64c5633s.jpg)](https://file.modx.pro/files/1/e/a/1ea6b3eae431ab23f9a005d9a64c5633.png)