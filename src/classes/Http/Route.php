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
        $this->invokeRequest('POST');
    }

    private function invokeGet() {
        $this->invokeRequest('GET');
    }

    private function invokeRequest($requestMethod){
        /* 
        *   Je nach Requestmethode werden hier die entsprechenden Eigenschaften referenziert,
        *   die in der folgenden foreach Schleife benötigt werden.
        */
        if ($requestMethod === 'POST') {
            $cMethod =& $this->_postControllerMethod;
            $uri =& $this->_uriPost;
        } elseif ($requestMethod === 'GET') {
            $cMethod =& $this->_getControllerMethod;
            $uri =& $this->_uriGet;
        }

        $uriGetParams = isset($_GET['uri']) ? $_GET['uri'] : '/';

        $urlNotFound = true;
        /* loop over GET or POST routes */
        foreach ($uri as $key => $uriVal) {
            if (preg_match("#^$uriVal$#", $uriGetParams)) {
                $urlNotFound = false;
                $controllerFunctionString = $cMethod[$key];
                $controllerFunctionArr = explode('@', $controllerFunctionString);

                $ns = Controller::getNamespace();            
                $controllerInstance = call_user_func([$ns . '\\' . $controllerFunctionArr[0], 'getInstance']);
                $controllerMethod = $controllerFunctionArr[1];
                call_user_func(array($controllerInstance, $controllerMethod));
                break;
            }
        }
        if($urlNotFound)
            return View::err404();
    }
}