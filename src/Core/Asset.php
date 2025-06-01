<?php

namespace NixPHP\View\Core;

use function NixPHP\View\s;

class Asset
{
    private const string TAG_CSS = '<link rel="stylesheet" href="%s">';
    private const string TAG_JS = '<script src="%s"></script>';
    private const string TAG_JS_MODULE = '<script type="module" src="%s"></script>';

    protected array $assets = [
        'css' => [],
        'js' => [
            'classic' => [],
            'module' => []
        ],
    ];

    public function add(string $path, string $mode = 'classic'): void
    {
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        if ($ext === 'css') {
            $this->assets['css'][] = $path;
        } elseif ($ext === 'js') {
            $mode = strtolower($mode);
            if (!in_array($mode, ['classic', 'module'])) {
                $mode = 'classic';
            }
            $this->assets['js'][$mode][] = $path;
        }
    }

    public function list(string $type, string $mode = 'classic'): array
    {
        if ($type === 'js') {
            return array_unique($this->assets['js'][$mode] ?? []);
        }

        return array_unique($this->assets[$type] ?? []);
    }

    public function render(string $type): string
    {
        $html = '';

        if ($type === 'css') {
            foreach ($this->list('css') as $path) {
                $html .= sprintf(self::TAG_CSS, s($path)) . PHP_EOL;
            }
        } elseif ($type === 'js') {
            foreach ($this->list('js', 'classic') as $path) {
                $html .= sprintf(self::TAG_JS, s($path)) . PHP_EOL;
            }
            foreach ($this->list('js', 'module') as $path) {
                $html .= sprintf(self::TAG_JS_MODULE, s($path)) . PHP_EOL;
            }
        }

        return trim($html);
    }
}
