# Virtualmin API
![GitHub release (latest by date)](https://img.shields.io/github/v/release/fintech-systems/virtualmin-api) [![Build Status](https://app.travis-ci.com/fintech-systems/virtualmin-api.svg?branch=main)](https://app.travis-ci.com/fintech-systems/virtualmin-api) ![GitHub](https://img.shields.io/github/license/fintech-systems/virtualmin-api)

A Virtualmin API designed to run standalone or as part of a Laravel Application

Requirements:

- PHP 8.0
- A running Virtualmin server

Features:

- List Domains (Virtualmin output)
- Get Domains (User-Friendly Output)
- Change Plan
- List Plans (Virtualmin output)
- Get Plans (User-Friendly Output)

## Get Domains

Framework Agnostic PHP:

```php
use \FintechSystems\VirtualminApi\VirtualminApi;
$api = new VirtualminApi(
        'hostname' => 'virtualmin.test',
        'username' => 'root',
        'password' => '********'
    );
$api->getDomains();
```

Laravel App:

```php
VirtualminApi::getDomains();
```

Output:

Array of all domains on a Virtualmin server.

## Change Plan

Framework Agnostic PHP:

```php
use \FintechSystems\VirtualminApi\VirtualminApi;
$api = new VirtualminApi;
$api->changePlan('example.com', 'New Plan Name);
```

Laravel App:

```php
VirtualminApi::changePlan('example.com', 'New Plan Name);
```

## Testing

We have tests! Use the command below to run the tests.

Live API calls will be made otherwise causing your tests to fail.

`vendor/bin/phpunit --exclude-group=live`

### Coverage reports

To regenerate coverage reports:

`XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html=tests/coverage-report`

See also `.travis.yml`

We have a badge for Coverage but it's problematic due to Github issues:<br>
![Codecov branch](https://img.shields.io/codecov/c/github/fintech-systems/virtualmin-api/main) 

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Version Control

This application uses Semantic Versioning

https://semver.org/

## Local Editing

For local editing, add this to `composer.json`:

```json
"repositories" : [
        {
            "type": "path",
            "url": "../virtualmin-api"
        }
    ]
```

## Credits

This standalone package was inspired by video course by Marcel Pociot of BeyondCode:<br>
[PHP Package Development](https://beyondco.de/video-courses/php-package-development)

Before doing the video course I had developed many versions of the same thing but it was never standalone and as a consequence over the years it was difficult to maintain and quickly use in new projects.

## Credits

- [Eugene van der Merwe](https://github.com/eugenevdm)
- [Fabio Montefuscolo](https://github.com/fabiomontefuscolo)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.