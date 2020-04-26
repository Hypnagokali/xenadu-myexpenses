<?php
/**
 * index.php
 * 
 * Bootstrap file for the app
 * 
 * @author Stefan Simon <stefan.simon@lionysos.com>
 * 
 */

use Http\Route;

/*
    init
*/
require_once 'src/autoload.php';
session_start();

/*
    add routes
*/

$route = new Route();

$route->get('/', 'Controller@home');
$route->get('/login', 'Controller@login');
$route->post('/login', 'Controller@login');
$route->get('/logout', 'Controller@logout');
$route->get('/expenses', 'Controller@expenses');

/* 
 let's go! :)
*/
$route->submit();


