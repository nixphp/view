<?php

use NixPHP\View\Core\Asset;
use function NixPHP\app;

app()->container()->set('asset', function() {
    return new Asset();
});