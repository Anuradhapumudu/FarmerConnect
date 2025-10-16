<?php
    class Core{
        //URL format --> /controller/method/params
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct() {
            //print_r($this->getURL());

            $url = $this->getURL();
            
            if(file_exists('../app/controllers/'.ucwords($url[0]).'.php')){
                //If the controller exists, then load it
                $this->currentController = ucwords($url[0]);

                // Unset the controller in the URL
                unset($url[0]);

                //calling the controller
                require_once '../app/controllers/'.$this->currentController.'.php';
                
                //Intentiate the controller
                $this->currentController = new $this->currentController;

                //check whether the method exist or not
                if(isset($url[1])){
                    if(method_exists($this->currentController, $url[1])){
                        $this->currentMethod = $url[1];

                        unset($url[1]);
                    }
                }

                //GET parameter list
                $this->params = $url ? array_values($url) : [];

                //Call method and pass the parameter list
                call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
            }
            else{
                require_once '../app/views/404.php';
            }
        }

        public function getURL() {
            if(isset($_GET['url'])) {
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            } else {
                // Return default controller if no URL is set
                return ['Pages'];
            }
        }
    }
?>