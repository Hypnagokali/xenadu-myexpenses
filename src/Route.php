<?php

use View\View;
use Controller\Controller;

require_once 'Controller.php';

class Route 
{
    private $_uriGet = [];
    private $_uriPost = [];
    private $_getControllerMethod = [];
    private $_postControllerMethod = [];

    public function get($uri, $method = null) {
        if (preg_match('/\/.+/', $uri)) {
            $this->_uriGet []= trim($uri, '/');
        } else {
            $this->_uriGet []= $uri;
        }
        if ($method != null) {
            $this->_getControllerMethod []= $method;
        }
    }

    public function post($uri, $method = null) {
        if (preg_match('/\/.+/', $uri)) {
            $this->_uriPost []= trim($uri, '/');
        } else {
            $this->_uriPost []= $uri;
        }
        if ($method != null) {
            $this->_postControllerMethod []= $method;
        }
    }

    public function submit() {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET' : $this->invokeGet();
            break;
            case 'POST' : $this->invokePost();
            break;
        }
        
    }

    private function invokePost() {
        echo $uriPostParams = isset($_GET['uri']) ? $_GET['uri'] : '404';

        /* loop over POST routes */
        foreach ($this->_uriPost as $key => $uriVal) {
            if (preg_match("#^$uriVal$#", $uriPostParams)) {
                return View::display('success');
            }
        }
        return View::err404();

        if ($uriPostParams == '404') 
            return View::err404();
        else
            echo "was geht ab, sagt der POST";
    }

    private function invokeGet() {
        /* ersetze '/' durch ein 404 */
        echo $uriGetParams = isset($_GET['uri']) ? $_GET['uri'] : '/';
        echo "<br>";

        /* loop over GET routes */
        foreach ($this->_uriGet as $key => $uriVal) {

            if (preg_match("#^$uriVal$#", $uriGetParams)) {

                $controllerFunctionString = $this->_getControllerMethod[$key];
                $controllerFunctionArr = explode('@', $controllerFunctionString);
                /* call_user_func benötigt immer den gesamten Klassenaufruf mitsamt namespace */
                $ns = Controller::getNamespace();
                call_user_func(array($ns . "\\" . $controllerFunctionArr[0], $controllerFunctionArr[1]));
                break;
            }
        }
        return View::err404();

    }
}