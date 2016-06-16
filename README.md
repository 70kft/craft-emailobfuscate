# EmailObfuscate plugin for Craft CMS

A plugin to [obfuscate](//ssl.gstatic.com/dictionary/static/sounds/de/0/obfuscate.mp3) email addresses in strings. Specifically intended to parse rich text field output in templates, find, and replace mailto links with obfuscated gobbledygook.

Super-basic usage. It's just a filter so use like so:
```
{{ entry.body|emailObfuscate }}
```

The method of obfuscation is borrowed [directly](http://snipplr.com/view/6037/php-javascript-rot13-encoder-function/) from a person.

#### Credit

Thanks to [Matt Stauffer](https://github.com/mattstauffer/craftcms-linkHelpers) since I took some notes from his Twig LinkHelpers plugin and to [Barrel Strength Design's](https://straightupcraft.com/craft-plugins/encode-email) Sprout Encode Email plugin which I would have used instead of writing EmailObfuscate if only it handled searching through RTE output to find/replace mailto links.