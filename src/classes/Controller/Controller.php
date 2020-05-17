<?php
namespace Controller;

use Controller\AbstractController;
use View\View;
use Auth\User;
use Http\Redirect;

class Controller extends AbstractController {

    protected static $_instance = null;

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new Controller();
        }
        return self::$_instance;
    }
    /* 
        InputRequest Controller mapping request to get or post
    */
    public function home() {
        return View::display('index');
    }

    public function login() {
        if(User::id() === null) {
            return View::display('login');
        } else {
            echo "Du bist doch bereits eingeloggt :)";
        }    
    }

    public function logout() {
        User::logout();
        Redirect::to('/');
    }

    public function expenses() {
        return View::display('expenses');
    }

    /* 
        POST Controller:
    */
    public function loginPost() {
        $userLoggedIn = User::login($_POST['name'], $_POST['password']);
        if ($userLoggedIn) {
            Redirect::to('/');
        } else {
            Redirect::to('/');
        }
    }

}