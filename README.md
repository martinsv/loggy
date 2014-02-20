# Loggy

This is a simple logger in php to log applications.

## Requirements

* PHP 5.x

## Usage

The [example][example] are a good place to start.

See a sample code:

```php
require_once 'lib/Loggy.php';

$arr = array('Key 1' => 'Value 1', 'Key 2' => 2);

Loggy::debug('Debug 1');
Loggy::error('Error 1');
Loggy::notice('Notice 1');
Loggy::debug($arr);


$slog = Loggy::getLogger();
$slog->debug('Debug 2');
$slog->error('Error 2');
$slog->notice('Notice 2');
$slog->debug($arr); 
```