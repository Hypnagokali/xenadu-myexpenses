<?php
namespace Controller;

use Controller\AbstractController;
use View\View;

class Controller extends AbstractController {

    static public function home() {
        return View::display('index');
    }

    static public function expenses() {
       return View::display('expenses');
    }

}