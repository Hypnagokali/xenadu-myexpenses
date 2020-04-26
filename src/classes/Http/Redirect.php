<?php
namespace Http;

class Redirect {

    static private $redirecBasetUrl = 'http://localhost/xenadu/myexpenses';

    static public function to($url) {
        //url can be '/' or '/whatever-route-you-meed'
        //thats why, $redirecBasetUrl doesn't end with a slash
        header('Location: ' . self::$redirecBasetUrl . $url);
    }

}