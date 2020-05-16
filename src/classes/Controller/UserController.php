<?php

namespace Controller;

use Controller\Controller;
use View\View;

class UserController extends Controller {

    protected static $_instance = null;

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new UserController();
        }
        return self::$_instance;
    }

    protected function __clone() {}
    protected function __construct() {}

    public function getUser($uid) {

    }

    public function hashMyString() {
        View::display('hash');
    }

    public function hashMyStringPost() {
        $password = $_POST['inp-str'];
        $start = microtime(true);
        $phash = $hashed_password = password_hash($password, PASSWORD_ARGON2I);
        $end = microtime(true);
        echo $phash . "<br>";
        $time = $end - $start;
        echo "time: " . $time;
    }

    public function verifyPost() {
        $password = $_POST['password'];
        $teststring = '$argon2i$v=19$m=65536,t=4,p=1$SndmUFdiMXF4WHVKaFBKbw$OORe8UnqiH8+p2x8SGWUYB5rN/Lk+cyrlrrb4YYDgow';
        $test = password_verify($password, $teststring) ? "Yeah, läuft!" : "Das war ein missgeschick!";
        echo $test . "<br>";
        echo strlen($teststring);
    }
}