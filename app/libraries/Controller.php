<?php
    class Controller {
        //To load model
        public function model($model) {
            require_once '../app/models/' . $model . '.php';
            //Instentiate the model and paste it to the controller member variable
            return new $model();
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