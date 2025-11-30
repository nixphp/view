<?php

declare(strict_types=1);

namespace NixPHP\View\Core;

use function NixPHP\app;
use function NixPHP\guard;
use function NixPHP\plugin;

class View
{
    private View|null $layout = null;
    private array $variables = [];
    private string|null $template = null;

    /**
     * @param string $template
     *
     * @return $this
     */
    public function setLayout(string $template): View
    {
        $this->layout = new View();
        $this->layout->setTemplate($template);
        return $this;
    }

    /**
     * @param string $template
     *
     * @return $this
     */
    public function setTemplate(string $template): View
    {
        $template = $this->buildTemplatePath($template);
        $this->template = $template;
        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setVariable(string $key, mixed $value): View
    {
        $this->variables[$key] = $value;
        return $this;
    }

    /**
     * @param array $variables
     *
     * @return $this
     */
    public function setVariables(array $variables): View
    {
        $this->variables = $variables;
        return $this;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        ob_start();
        extract($this->variables);
        include $this->template;
        $content = ob_get_clean();

        if ($this->layout instanceof View) {
            return $this->layout->setVariables($this->variables)->render();
        }

        return $content;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function block(string $name): void
    {
        $this->variables[$name] = 'initial';
        ob_start();
    }

    /**
     * @param string $name
     *
     * @return void
     * @throws \Exception
     */
    public function endblock(string $name): void
    {
        if (!isset($this->variables[$name])) {
            ob_end_clean();
            throw new \Exception("Block $name was not opened. ");
        }
        $this->variables[$name] = ob_get_clean();
    }

    /**
     * @param string $name
     * @param string $default
     *
     * @return string
     */
    public function renderBlock(string $name, string $default = ''): string
    {
        return $this->variables[$name] ?? $default;
    }

    /**
     * @param string $templateName
     *
     * @return string
     */
    private function buildTemplatePath(string $templateName): string
    {
        $templateName = guard()->safePath($templateName);

        $paths = [
            app()->getBasePath() . '/app/views', // App views
            ...array_filter(array_map('realpath', app()->collectPluginResources('viewPaths'))), // Plugin views
            __DIR__ . '/../Resources/views', // Framework views
        ];

        foreach ($paths as $path) {
            $fullPath = sprintf('%s/%s.phtml', rtrim($path, '/'), str_replace('.', '/', $templateName));
            if (is_file($fullPath)) return $fullPath;
        }

        throw new \RuntimeException("View $templateName not found in any known paths.");
    }

}