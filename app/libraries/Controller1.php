<?php
class Controller {
    // To load model
    public function model($model, $db = null) {
        require_once '../app/models/' . $model . '.php';

        // Extract class name from path (last part after /)
        $modelParts = explode('/', $model);
        $className = end($modelParts);

        if ($db) {
            return new $className($db); // pass database object
        } else {
            return new $className(); // fallback, if no db needed
        }
    }

    // To load the view
    public function view($view, $data = []) {
        if(file_exists('../app/views/'.$view.'.php')) {
            require_once '../app/views/'.$view.'.php';
        } else {
            require_once '../app/views/404.php';
            die('Corresponding view does not exist');
        }
    }
}
?>
