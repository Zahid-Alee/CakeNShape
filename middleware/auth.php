<?php

namespace authMiddleware;
// use DataSource\user;
// header('Cache-Control: no-store, no-cache, must-revalidate');
// header('Expires: 0');


class AuthMiddleware
{
    public static function checkAuth()
    {
        session_start();
        if (isset($_SESSION["username"])) {
            $username = $_SESSION["username"];
            session_write_close();
            return $username;
            // exit;
        } else {
            
            return false;
            exit;
        }
        
    }
    // public static function logout(){

    //     session_unset();
    //     session_destroy();
    //     header("Location: ./login.php");
    // }
}
