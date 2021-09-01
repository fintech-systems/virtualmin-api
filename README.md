# Virtualmin API
![GitHub release (latest by date)](https://img.shields.io/github/v/release/fintech-systems/virtualmin-api) [![Build Status](https://app.travis-ci.com/fintech-systems/virtualmin-api.svg?branch=main)](https://app.travis-ci.com/fintech-systems/virtualmin-api) ![Codecov branch](https://img.shields.io/codecov/c/github/fintech-systems/virtualmin-api/main) ![GitHub](https://img.shields.io/github/license/fintech-systems/virtualmin-api)
A Virtualmin API designed to run standalone or as part of a Laravel Application

Features:

- Auditing

# Tests

We have tests!

## Coverage reports

To regenerate coverage reports:

`XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html=tests/coverage-report`

See also `.travis.yml`

# Semver

We use Semantic Versioning
https://semver.org/

# Local Editing

For local editing, add this to `composer.json`:

```json
"repositories" : [
        {
            "type": "path",
            "url": "../virtualmin-api"
        }
    ]
```json