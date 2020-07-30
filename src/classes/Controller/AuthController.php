<?php
namespace Controller;

use Auth\Auth;
use Http\Redirect;
use View\View;

class AuthController extends AbstractController
{

    private static $instance = null;

    protected function __construct() {}
    protected function __clone() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new AuthController();
        }
        return self::$instance;
    }

    public function login()
    {
        View::display('login');
    }

    public function logout()
    {
        Auth::logout();
        Redirect::to('/login');
    }

    public function loginPost()
    {
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        /* E-Mail validation */
        //phpcs:disable
        if (empty($email) || empty($password)) {
            $_SESSION['flash']['login'] = 'E-Mail und Passwortfeld dürfen nicht leer sein!';
            Redirect::to('/login');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash']['login'] = 'Bitte eine gültige E-Mail Adresse angeben!';
            Redirect::to('/login');
        }
        
        //phpcs:enable
        /* Try to login user */
        if (Auth::login($email, $password)) {
            Redirect::to('/');
        } else {
            $_SESSION['flash']['login'] = 'Falsche E-Mail oder falsches Passwort!';
            Redirect::to('/login');
        };
    }
}