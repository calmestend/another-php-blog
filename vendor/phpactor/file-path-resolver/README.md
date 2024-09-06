File Path Resolver
==================

![CI](https://github.com/phpactor/file-path-resolver/workflows/CI/badge.svg)

Resolves file paths by filtering and replacing tokens with values.

- Canonicalization support via `webmozart/path-util`
- XDG directory expansion via `dnoegel/php-xdg-base-dir`

This package can be used in, for example, a CLI application such as
[Phpactor](https://github.com/phpactor/phpactor') to resolve application
paths.

Usage
-----

```php
$pathResolver = new PathResolver([
    new CanonicalizationFilter(),
    new TokenExpandingFilter([
        new ValueExpander('%my_token%', 'my_value'),
        new XdgCacheExpander('%xdg_cache%'),
        new XdgConfigExpander('%xdg_conifg%'),
        new CallbackExpander('%callback%', function () {
            return 'hello from callback';
        });
    ])
]);

$pathResolver->resolve('/foo/../foo/%my_token%'); // foo/my_value
$pathResolver->resolve('%xdg_home%/my_app'); // /home/user/.config/my_app
$pathResolver->resolve('%callback%'); // hello from callback
```

Contributing
------------

This package is open source and welcomes contributions! Feel free to open a
pull request on this repository.

Support
-------

- Create an issue on the main [Phpactor](https://github.com/phpactor/phpactor) repository.
- Join the `#phpactor` channel on the Slack [Symfony Devs](https://symfony.com/slack-invite) channel.

