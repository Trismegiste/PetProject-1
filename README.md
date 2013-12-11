# Pet project 1

Practicing da web with the opensource ecosystem

 * KISS
 * minimal coding
 * no monkey patching

## Components used in this app

 * [Symfony 2.3](http://symfony.com/) with minimal config (without doctrine, swiftmailer and ExtraGizmo)
 * [HTML5 Boilerplate with Twitter Bootstrap 2.3](http://html5boilerplate.com/)
 * [Markdown renderer](https://github.com/michelf/php-markdown)
 * [Mention.js](https://github.com/jakiestfu/Mention.js) for autocomplete with link
 * [trismegiste/dokudoki](https://github.com/Trismegiste/DokudokiBundle) for NoSQL persistence
 * [trismegiste/php-is-magic](https://github.com/Trismegiste/Php-Is-Magic) because I'm too lazy to write getter/setter
 * [MongoDb 2.4](http://mongodb.com) because NoSQL rox
 * Twig Form theming taken from [Silex Kitchen Edition](https://github.com/lyrixx/Silex-Kitchen-Edition)
 * the awesome [d3js](https://github.com) for drawing graph

## Some useful things

 * extension of Markdown syntax for rendering links "@slug-url"
 * a twig extension filter for markdown format
 * an history stack in session like the "Recently Viewed Items" of many e-commerce
 * Compiler Pass of Container for editing the service "session" of symfony
 * using fluid grid of tbs
 * enabling magic call in symfony/form
 * using model factory in symfony/form