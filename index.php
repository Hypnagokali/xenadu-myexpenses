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
setlocale(LC_TIME, 'de_DE');

use Http\Route;

/*
    init
*/
require_once 'src/autoload.php';
require_once 'src/functions.php';

if (!session_id()) {
    session_start();
}
/*
    add routes
*/

$route = new Route();

$route->get('/', 'Controller@home');

//$route->get('/login', 'Controller@login');
//$route->post('/login', 'Controller@loginPost');

$route->get('/login', 'AuthController@login');
$route->post('/login', 'AuthController@loginPost');

$route->get('/logout', 'Controller@logout');

$route->post('/expenses/add', 'MyExpensesController@addExpensesPost');
/*
$route->get('/get/all', 'MyExpensesController@getAllExpenses');
$route->get('/mappertest', 'MyExpensesController@testMapper');
$route->get('/testdb', 'UserController@testDb');*/

$route->get('/register', 'UserController@hashMyString');
$route->post('/register', 'UserController@hashMyStringPost');
$route->post('/verify', 'UserController@verifyPost');

$route->get('/expenses', 'Controller@expenses');
$route->get('/myexpenses', 'MyExpensesController@displayExpenses');

/* 
 let's go! :)
*/
$route->submit();


