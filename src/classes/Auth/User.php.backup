<?php
namespace Auth;

class User {
    static private $_uid = null;
    static private $_uname = null;
    static private $_usession = null;

    static private $_myName = "StefanJC";
    static private $_myPass = "imceobitch";
    static private $_myId = 1;

    static public function id() {
        if(self::auth())
            return self::$_uid;
    }

    static public function name() {
        if(self::auth())
            return self::$_uname;
    }

    /*
    static public function session() {
        return self::$_usession;
    }*/

    static public function login($name, $password) {
        if ($name === self::$_myName && $password === self::$_myPass) {
            self::$_uid = $_SESSION['uid'] = self::$_myId;
            self::$_uname = $_SESSION['name'] = self::$_myName;
                       
            $expires = time() + 60 * 60 * 24 * 3;

            setcookie('uid', User::id(), $expires);
            setcookie('name', User::name(), $expires);

            return true;
        }
        return false;
    }

    static public function logout() {
        if (isset($_SESSION['uid']) && isset($_COOKIE['uid'])) {
            unset($_SESSION['uid']);
            unset($_COOKIE['uid']);
            setcookie('uid', '', time() - 3000);
            setcookie('name', '', time() - 3000);
            session_destroy();
            setcookie(session_name(), '', time() - 3000, '/');
        }
        self::$_uid = self::$_uname = null;
    }

    static public function auth() {
        if(isset($_SESSION['uid']) && isset($_SESSION['name'])) {
            self::$_uid = $_SESSION['uid'];
            self::$_uname = $_SESSION['name'];
            return true;
        } else {
            if (isset($_COOKIE['uid']) && isset ($_COOKIE['name'])) {
                self::$_uid = $_SESSION['uid'] = $_COOKIE['uid'];
                self::$_uname = $_SESSION['name'] = $_COOKIE['name'];
            } else {
                return false;
            }
        }
    }
}