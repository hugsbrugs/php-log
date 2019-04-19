# php-log

This librairy provides utilities function for simple file logging support.

[![Build Status](https://travis-ci.org/hugsbrugs/php-log.svg?branch=master)](https://travis-ci.org/hugsbrugs/php-log)
[![Coverage Status](https://coveralls.io/repos/github/hugsbrugs/php-log/badge.svg?branch=master)](https://coveralls.io/github/hugsbrugs/php-log?branch=master)

## Install

Install package with composer
```
composer require hugsbrugs/php-log
```

In your PHP code, load library
```php
require_once __DIR__ . '/../vendor/autoload.php';
use Hug\Log\Log as Log;
```

## Usage

Writes the values of certain variables (time, remote_addr, request_uri) along with a message in a log file.
```php
Log::write_log($message, $logfile = null);
```
If $logfile is not defined then you have to define a constant DEFAULT_LOG with path to default log file

Transforms a PHP integer error code into a human readable PHP constant
```php
$log_message = Log::decode_log_level($error_code);
```

## Unit Tests

```
phpunit --bootstrap vendor/autoload.php tests
```

## Author

Hugo Maugey [visit my website ;)](https://hugo.maugey.fr)