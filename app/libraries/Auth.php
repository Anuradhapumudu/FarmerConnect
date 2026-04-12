<?php

class Auth {

//start session if its not started
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    
    public static function check() {
        self::startSession();

        //if user_type not valid  or user_id is not valid direct to login page
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['user_id'])) {
            self::redirect('/users/login');
        }
    }

    //check user role(farmer, seller , officer)
    public static function checkRole($role) {
        self::startSession();

        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== $role) {
            self::redirect('/users/login');
        }
    }


    //check user role admin
    public static function checkAdmin() {
        self::startSession();

        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
            self::redirect('/admin/adminlogin');
        }
    }

    private static function redirect($path) {
        header('Location: ' . URLROOT . $path);
        exit;
    }
}