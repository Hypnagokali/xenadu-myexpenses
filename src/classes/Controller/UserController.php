<?php

namespace Controller;

use Controller\Controller;
use View\View;
use Db\MySQLConnection;

class UserController extends Controller {

    protected static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new UserController();
        }
        return self::$instance;
    }

    protected function __clone() {}
    protected function __construct() {}

    public function testDb()
    {
        $uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

        $dbConfig = app('db');
        $conn = new MySQLConnection($dbConfig);

        $myExpenses = $conn->getAllExpensesFromUser($uid);
        foreach ($myExpenses as $row) {
            echo "Ausgaben: " . $row['sum'] . '<br>';
            echo "Wo : " . $row['location'] . '<br>';
        }
        echo "Hallo DB";
    }

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