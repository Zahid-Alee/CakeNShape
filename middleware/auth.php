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
            // since the username is not set in session, the user is not-logged-in
            // he is trying to access this page unauthorized
            // so let's clear all session variables and redirect him to login
            // self::logout();
            // header('Location:','./logout.php');
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
