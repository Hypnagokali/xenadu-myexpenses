<?php
namespace Controller;

use Controller\AbstractController;
use View\View;
use Auth\Auth;
use Http\Redirect;

class Controller extends AbstractController
{

    protected static $_instance = null;

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new Controller();
        }
        return self::$_instance;
    }
    /* 
        InputRequest Controller mapping request to get or post
    */
    public function home()
    {
        return View::display('index');
    }

    public function login()
    {
        if (!Auth::auth()) {
            return View::display('login');
        } else {
            return View::display('index');
        }
    }

    public function logout()
    {
        Auth::logout();
        Redirect::to('/');
    }

    public function expenses()
    {
        return View::display('expenses');
    }

    /* 
        POST Controller:
    */
    public function loginPost() {
        $userLoggedIn = Auth::login($_POST['name'], $_POST['password']);
        if ($userLoggedIn) {
            Redirect::to('/');
        } else {
            Redirect::to('/');
        }
    }
}
