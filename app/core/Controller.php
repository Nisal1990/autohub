<?php
/**
 * AutoHub LK — Base Controller
 */

class Controller
{
    /**
     * Render a view file inside a layout.
     *
     * @param string $view     Path relative to /app/views/, e.g. 'home/index'
     * @param array  $data     Variables to extract into view scope
     * @param string $layout   Layout file name in /app/views/layouts/
     */
    protected function view(string $view, array $data = [], string $layout = 'public'): void
    {
        // Extract data so view can use $variables directly
        extract($data);

        // Capture the view content
        $viewFile = APP_ROOT . '/app/views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            http_response_code(500);
            die('View not found: ' . htmlspecialchars($view));
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Load the layout (which will echo $content)
        $layoutFile = APP_ROOT . '/app/views/layouts/' . $layout . '.php';
        if (!file_exists($layoutFile)) {
            echo $content;
            return;
        }
        require $layoutFile;
    }

    /**
     * Redirect to a URL.
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    /**
     * Send a JSON response and exit.
     */
    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    /**
     * Set a flash message in the session.
     */
    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;
    }

    /**
     * Return POST data, optionally sanitized.
     */
    protected function post(string $key, mixed $default = ''): mixed
    {
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
    }

    /**
     * Return GET data.
     */
    protected function get(string $key, mixed $default = ''): mixed
    {
        return isset($_GET[$key]) ? trim($_GET[$key]) : $default;
    }

    /**
     * Abort with an HTTP error code and a simple message.
     */
    protected function abort(int $code = 404, string $message = 'Not Found'): void
    {
        http_response_code($code);
        $title = $code . ' — ' . $message;
        $this->view('errors/error', ['title' => $title, 'code' => $code, 'message' => $message]);
        exit;
    }
}
