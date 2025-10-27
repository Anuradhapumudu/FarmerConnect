<?php
class Core {
    // URL format --> /folder/controller/method/params
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->getURL();

        $controllerPath = '../app/controllers/';

        // Check if first part is a folder
        if(isset($url[0]) && is_dir($controllerPath . ucwords($url[0]))) {
            $folder = ucwords($url[0]);
            $controllerPath .= $folder . '/';
            unset($url[0]);

            // Now check the next part for controller
            if(isset($url[1]) && file_exists($controllerPath . ucwords($url[1]) . '.php')) {
                $this->currentController = ucwords($url[1]);
                unset($url[1]);
            } else {
                // No controller found in folder, fallback
                require_once '../app/views/404.php';
                return;
            }
        } elseif(isset($url[0]) && file_exists($controllerPath . ucwords($url[0]) . '.php')) {
            // No folder, just controller
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        } else {
            // Controller doesn't exist
            require_once '../app/views/404.php';
            return;
        }

        // Include the controller file
        require_once $controllerPath . $this->currentController . '.php';

        // Instantiate the controller
        $this->currentController = new $this->currentController;


        // After unsetting controller index, the next URL segment is method
        /*    $methodIndex = isset($folder) ? 2 : 1; // if folder exists, method is at url[2], else url[1]
            if(isset($url[$methodIndex]) && method_exists($this->currentController, $url[$methodIndex])) {
                $this->currentMethod = $url[$methodIndex];
                unset($url[$methodIndex]);
            }
        // Check for method
        if(isset($url[1])) {
            if(method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }*/
        $methodIndex = isset($folder) ? 2 : 1; // if folder exists, method is at url[2], else url[1]
        if(isset($url[$methodIndex]) && method_exists($this->currentController, $url[$methodIndex])) {
            $this->currentMethod = $url[$methodIndex];
            unset($url[$methodIndex]);
        }


        // Get parameters
        $this->params = $url ? array_values($url) : [];

        // Call the method with params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getURL() {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        } else {
            return ['Pages'];
        }
    }
}
?>
