
Saasu PHP API
=======

This library is a REST client for Saasu webservice API
(http://help.saasu.com/api/).


Usage
-----

If you need a logger, you can use the interface like this:

```php
<?php

use Psr\Log\LoggerInterface;

class Foo
{
    private $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    public function doSomething()
    {
        if ($this->logger) {
            $this->logger->info('Doing work');
        }

        // do something useful
    }
}
```

You can then pick one of the implementations of the interface to get a logger.

If you want to implement the interface, you can require this package and
implement `Psr\Log\LoggerInterface` in your code. Please read the
[specification text](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md)
for details.
