<?php
namespace Controller;

use Controller\AbstractController;
use View\View;
use Auth\User;
use Http\Redirect;

class Controller extends AbstractController {

    /* 
        InputRequest Controller mapping request to get or post
    */
    static public function home($methodPost = false) {
        return View::display('index');
    }

    static public function login($methodPost = 'get') {
        if ($methodPost === 'post') {
            self::loginPost($_POST);
        } else {
            self::loginGet($_GET);
        }      
    }

    /*
        GET Controller:
    */

    static public function logout() {
        User::logout();
        Redirect::to('/');
    }

    static public function loginGet($requestParameters) {
        if(User::id() === null) {
            return View::display('login');
        } else {
            echo "Du bist doch bereits eingeloggt :)";
        }
    }

    static public function expenses($methodPost = false) {
        //$queryString = isset($_GET['muh']) ? $_GET['muh'] : '';
        //echo "<p>query = $queryString</p>";
        return View::display('expenses');
    }

    /* 
        POST Controller:
    */
    static public function loginPost($requestParameters) {
        $userLoggedIn = User::login($requestParameters['name'], $requestParameters['password']);
        if ($userLoggedIn) {
            Redirect::to('/expenses');
        } else {
            Redirect::to('/');
        }
    }

}