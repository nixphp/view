<?php

declare(strict_types=1);

use NixPHP\View\Core\Asset;
use function NixPHP\app;

app()->container()->set(Asset::class, function() {
    return new Asset();
});