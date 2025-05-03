<?php

namespace NixPHP\View;

use NixPHP\View\Core\Asset;
use NixPHP\View\Core\View;
use Psr\Http\Message\ResponseInterface;
use function NixPHP\app;
use function NixPHP\response;

function render(string $template, array $vars = []): ResponseInterface
{
    return response(\NixPHP\View\view($template, $vars));
}

function view(string $template, array $vars = []): string
{
    return (new View())->setTemplate($template)->setVariables($vars)->render();
}

function asset(): Asset
{
    return app()->container()->get('asset');
}