<?php
namespace Auth;

class User {
    static private $_uid = null;
    static private $_uname = null;
    static private $_usession = null;

    static private $_myName = "stefan";
    static private $_myPass = "imceobitch";
    static private $_myId = 1;

    static public function id() {
        return self::$_uid;
    }

    static public function name() {
        return self::$_uname;
    }

    static public function session() {
        return self::$_usession;
    }

    static public function login($name, $password) {
        if ($name === self::$_myName && $password === self::$_myPass) {
            self::$_uid = self::$_myId;
            self::$_uname = self::$_myName;
            $_SESSION['uid'] = User::id();
            $expires = time() + 60 * 60 * 24 * 3;
            setcookie('uid', User::id(), $expires);
            return true;
        }
        return false;
    }

    static public function logout() {
        if (isset($_SESSION['uid']) && isset($_COOKIE['uid'])) {
            unset($_SESSION['uid']);
            unset($_COOKIE['uid']);
            setcookie('uid', '', time() - 3000);
            session_destroy();
            setcookie(session_name(), '', time() - 3000, '/');
        }
        self::$_uid = null;
    }
}