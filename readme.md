# Web app generator with PHP

Yeoman generator that scaffolds out a front-end web app with a PHP back-end.

[![NPM version](https://badge.fury.io/js/generator-webapp-php.png)](http://badge.fury.io/js/generator-webapp-php)
[![Build Status](https://secure.travis-ci.org/amercier/generator-webapp-php.png?branch=master)](http://travis-ci.org/amercier/generator-webapp-php)
[![Dependency Status](https://gemnasium.com/amercier/generator-webapp-php.png)](https://gemnasium.com/amercier/generator-webapp-php)

Based on [generator-webapp](https://github.com/yeoman/generator-webapp). Adds
a `/app/api` folder containing a sample RESTful PHP API. The API is available under
`/api` URL. `During development, the PHP API is served by
[PHP built-in web server](http://php.net/manual/en/features.commandline.webserver.php)
and integrated seamlessly into the existing [connect](https://github.com/gruntjs/grunt-contrib-connect)
configuration. Integration is done with [grunt-connect-proxy](https://github.com/drewzboto/grunt-connect-proxy)
and a [patched version](https://github.com/amercier/grunt-php) of
[grunt-php](https://github.com/sindresorhus/grunt-php) (see [PR #15](https://github.com/sindresorhus/grunt-php/pull/15) for details).


## Features

* CSS Autoprefixing (new)
* Built-in preview server with LiveReload
* Automagically compile CoffeeScript & Compass
* Automagically lint your scripts
* Automagically wire up your Bower components with [bower-install](https://github.com/stephenplusplus/grunt-bower-install).
* Awesome Image Optimization (via OptiPNG, pngquant, jpegtran and gifsicle)
* Mocha Unit Testing with PhantomJS
* Optional - Twitter Bootstrap for SASS
* Optional - Leaner Modernizr builds (new)

For more information on what `generator-webapp-php` can do for you, take a look at the [Grunt tasks](https://github.com/amercier/generator-webapp-php/blob/master/app/templates/_package.json) used in our `package.json`.

## Getting Started

- Install: `npm install -g generator-webapp-php`
- Run: `yo webapp-php`
- Run `grunt` for building and `grunt serve` for preview


## Options

* `--skip-install`

  Skips the automatic execution of `bower` and `npm` after scaffolding has finished.

* `--test-framework=<framework>`

  Defaults to `mocha`. Can be switched for another supported testing framework like `jasmine`.

* `--coffee`

  Add support for [CoffeeScript](http://coffeescript.org/).

## Contribute

See the [contributing docs](https://github.com/yeoman/yeoman/blob/master/contributing.md)

Note: We are regularly asked whether we can add or take away features. If a change is good enough to have a positive impact on all users, we are happy to consider it.

If not, `generator-webapp-php` is fork-friendly and you can always maintain a custom version which you `npm install && npm link` to continue using via `yo webapp-php` or a name of your choosing.


## License

[MIT license](https://github.com/amercier/generator-webapp-php/blob/master/)
