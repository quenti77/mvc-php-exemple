<?php

namespace Mvc\Http;

/**
 * Class HtmlResponse
 * @package Mvc\Http
 */
class HtmlResponse extends Response
{
    /** @var string $view */
    private $view;

    /** @var array $params */
    private $params;

    /** @var string|null $layout */
    private $layout;

    /**
     * HtmlResponse constructor.
     * @param string $view
     * @param array $params
     * @param string|null $layout
     */
    public function __construct(string $view, array $params = [], string $layout = null)
    {
        $this->view = $view;
        $this->params = $params;
        $this->layout = $layout;
    }

    public function render(): void
    {
        $viewFile = ROOT_PATH . "/app/views/{$this->view}.php";

        extract($this->params);

        ob_start();

        /** @noinspection PhpIncludeInspection */
        require $viewFile;

        $content = ob_get_clean();

        if ($this->layout) {
            $layoutFile = ROOT_PATH . "/app/views/layouts/{$this->layout}.php";

            ob_start();

            /** @noinspection PhpIncludeInspection */
            require $layoutFile;

            $content = ob_get_clean();
        }

        echo $content;
    }
}
