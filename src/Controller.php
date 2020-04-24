<?php
namespace Controller;

require_once 'AbstractController.php';

use Controller\AbstractController;
use View\View;

class Controller extends AbstractController {

    public static function home() {
        return View::display('index');
    }

    public static function expenses() {
       return View::display('expenses');
    }

}