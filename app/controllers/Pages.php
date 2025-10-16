<?php
    class Pages extends Controller {
        protected $pagesModel;

        public function __construct() {
            $this->pagesModel = $this->model('M_pages');
        }

        public function index() {
            $this->view('v_index');
        }

        public function disease() {
            $this->view('disease/report');
        }

        public function about($name) {
            $data = [
                'username' => $name
            ];
            $this->view('v_about', $data);
        }
    }
?>