<?php

declare(strict_types=1);

namespace NixPHP\View;

use NixPHP\View\Core\Asset;
use NixPHP\View\Core\View;
use Psr\Http\Message\ResponseInterface;
use function NixPHP\app;
use function NixPHP\guard;
use function NixPHP\response;

function s(string|array|null $value): string|array|null
{
    return guard()->safeOutput($value);
}

function render(string $template, array $vars = []): ResponseInterface
{
    return response(view($template, $vars));
}

function view(string $tpl, array $vars = []): string
{
    return (new View())->setTemplate($tpl)->setVariables($vars)->render();
}

function asset(): Asset
{
    return app()->container()->get(Asset::class);
}