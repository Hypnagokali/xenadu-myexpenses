<?php
namespace Controller;

use View\View;

class Controller {

    public function home() {
        View::display('index');
    }

    public function expenses() {
       return View::display('expenses');
    }

}