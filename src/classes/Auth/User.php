<?php
namespace Auth;

class User {
    static private $_uid = null;

    static private $_myName = "stefan";
    static private $_myPass = "imceobitch";
    static private $_myId = 1;

    static public function id() {
        
    }

    static public function name() {

    }

    static public function login($name, $password) {
        if ($name === self::$_myName && $password === self::$_myPass) {
            self::$_uid = self::$_myId;
        }
    }

    static public function logout() {
        self::$_uid = null;
    }
}