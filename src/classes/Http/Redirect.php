<?php
namespace Http;

class Redirect {

    private static $redirecBasetUrl = ''; //'http://localhost/xenadu/myexpenses';

    public static function to($url) {
        self::$redirecBasetUrl = baseUrl();
        //url can be '/' or '/whatever-route-you-meed'
        //thats why, $redirecBasetUrl doesn't end with a slash
        header('Location: ' . self::$redirecBasetUrl . $url);
        exit();
    }

}