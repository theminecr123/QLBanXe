<?php
class SessionHelper{
    static function isLoggedIn(){
        return isset($_SESSION['id']);
    }
    static function isMod(){
        return (isset($_SESSION['id']) && $_SESSION['role'] == 'mod');

    }
    static function isAdmin(){
        return (isset($_SESSION['id']) && $_SESSION['role'] == 'admin');

    }
    static function isUser(){
        return (isset($_SESSION['id']) && $_SESSION['role'] == 'user');

    }
}