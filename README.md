# Virtualmin API
![GitHub release (latest by date)](https://img.shields.io/github/v/release/fintech-systems/virtualmin-api) [![Build Status](https://app.travis-ci.com/fintech-systems/virtualmin-api.svg?branch=main)](https://app.travis-ci.com/fintech-systems/virtualmin-api) ![GitHub](https://img.shields.io/github/license/fintech-systems/virtualmin-api)

A Virtualmin API designed to run standalone or as part of a Laravel Application

Requirements:

- PHP 8.0
- A running Virtualmin server, using the [Remote API](https://www.virtualmin.com/documentation/developer/http/)

Features:

- List Domains (Virtualmin output)
- Get Domains (User-Friendly Output)
- Change Plan
- List Plans (Virtualmin output)
- Get Plans (User-Friendly Output)
- Create Domain

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
$api->changePlan('example.com', 'New Plan Name');
```

Laravel App:

```php
VirtualminApi::changePlan('example.com', 'New Plan Name');
```

## Create Domain

Example:

```php
$api->createDomain([
    // New virtual server details
    'domain'                 => 'demo.example.com',
    'desc'                   => 'My demo website',
    'pass'                   => '***************',
    'template'               => 'WikiSuite 1',
    'plan'                   => 'WikiSuite 1',
    
    // Advanced options
    'email'                  => 'contact@example.com',
    'db'                     => 'demo_example_com',
    
    // Enabled features
    'features-from-plan'     => '',
    'virtualmin-tikimanager' => ''
]))
```

## Testing

We have tests! Use the command below to run the tests.

Live API calls will be made otherwise causing your tests to fail.

`vendor/bin/phpunit --exclude-group=live`

### Coverage reports

To regenerate coverage reports:

`XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html=tests/coverage-report`

See also `.travis.yml`

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

- [Domeshow](https://github.com/Domeshow)
- [Eugene van der Merwe](https://github.com/eugenevdm)
- [Fabio Montefuscolo](https://github.com/fabiomontefuscolo)
- [Marc Laporte](https://github.com/marclaporte)

## Inspiration

This standalone package was inspired by video course by Marcel Pociot of BeyondCode:<br>
[PHP Package Development](https://beyondco.de/video-courses/php-package-development)

Before doing the video course I had developed many versions of the same thing but it was never standalone and as a consequence over the years it was difficult to maintain and quickly use in new projects.

## How to contribute

Please add issues and merge requests via GitHub. 

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
