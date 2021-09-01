# Virtualmin API
A Virtualmin API designed to run standalone or as part of a Laravel Application

Features:

- Auditing

# Tests

We have tests!

Code coverage: ?

To regenerate coverage reports:

`XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html=tests/coverage-report`

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