<?php

namespace Http;

use View\View;
use Controller\Controller;

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
        $uriPostParams = isset($_GET['uri']) ? $_GET['uri'] : '/';
        $urlNotFound = true;
        /* loop over POST routes */
        foreach ($this->_uriPost as $key => $uriVal) {
            if (preg_match("#^$uriVal$#", $uriPostParams)) {
                $urlNotFound = false;
                $controllerFunctionString = $this->_postControllerMethod[$key];
                $controllerFunctionArr = explode('@', $controllerFunctionString);
                /* call_user_func benötigt immer den gesamten Klassenaufruf mitsamt namespace */
                $ns = Controller::getNamespace();
                call_user_func(array($ns . "\\" . $controllerFunctionArr[0], $controllerFunctionArr[1]), 'post');
                break;
            }
        }
        if($urlNotFound)
            return View::err404();
    }

    private function invokeGet() {
        /* ersetze '/' durch ein 404 */
        $uriGetParams = isset($_GET['uri']) ? $_GET['uri'] : '/';
        $urlNotFound = true;
        /* loop over GET routes */
        foreach ($this->_uriGet as $key => $uriVal) {

            if (preg_match("#^$uriVal$#", $uriGetParams)) {
                $urlNotFound = false;
                $controllerFunctionString = $this->_getControllerMethod[$key];
                $controllerFunctionArr = explode('@', $controllerFunctionString);
                /* call_user_func benötigt immer den gesamten Klassenaufruf mitsamt namespace */
                $ns = Controller::getNamespace();
                //call_user_func('Controller\\' . $controllerFunctionArr[0] .'::' . $controllerFunctionArr[1]);
                call_user_func(array($ns . "\\" . $controllerFunctionArr[0], $controllerFunctionArr[1]), 'get');
                break;
            }
        }
        if($urlNotFound)
            return View::err404();

    }
}