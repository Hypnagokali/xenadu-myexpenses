<?php
namespace View;

class View 
{
    private static $pathProd = "http://www.xenadu.de/myexpenses/public/";
    private static $path = "./public/";
    private static $template = "no template";

    public static function display($html = 'index') {
        /* if (!file_exists($htmlFile)) */

        self::$template = self::$path . $html . '.html';
        ob_clean();
        ob_start();
         include self::$template;
         header('Content-Type: text/html');
        return ob_end_flush();
    }

    public static function err404() {
        self::$template = self::$path . 'e404.html';
        ob_clean();
        ob_start();
            include self::$template;
            header("HTTP/1.0 404 Not Found");
        ob_end_flush();
    }
}