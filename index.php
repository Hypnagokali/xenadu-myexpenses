<?php
/**
 * index.php
 * 
 * Bootstrap file for the app
 * 
 * @author Stefan Simon <stefan.simon@lionysos.com>
 * 
 */
error_reporting(-1);
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

use Http\Route;

/*
    init
*/
require_once 'src/autoload.php';
require_once 'src/functions.php';
session_start();

/*
    add routes
*/

$route = new Route();

$route->get('/', 'Controller@home');

//$route->get('/login', 'Controller@login');
//$route->post('/login', 'Controller@loginPost');

$route->get('/newlogin', 'AuthController@login');
$route->post('/newlogin', 'AuthController@loginPost');

$route->get('/logout', 'Controller@logout');

$route->get('/mappertest', 'MyExpensesController@testMapper');
$route->get('/testdb', 'UserController@testDb');

$route->get('/register', 'UserController@hashMyString');
$route->post('/register', 'UserController@hashMyStringPost');
$route->post('/verify', 'UserController@verifyPost');

$route->get('/expenses', 'Controller@expenses');

/* 
 let's go! :)
*/
$route->submit();


