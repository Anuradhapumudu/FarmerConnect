<?php
    class Controller {
        //To load model
        public function model($model, $db = null) {
    require_once '../app/models/' . $model . '.php';
    if ($db) {
        return new $model($db); // pass database object
    } else {
        return new $model(); // fallback, if no db needed
    }
}

        //To load the view
        public function view($view, $data = []) {
            if(file_exists(('../app/views/'.$view.'.php'))) {
                require_once '../app/views/'.$view.'.php';
            }
            else {
                require_once '../app/views/404.php';
                die('Corresponding view does not exists');
            }
        }
    }
?>