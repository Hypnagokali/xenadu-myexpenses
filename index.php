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

require_once 'src/autoload.php';



$route = new Route();

$route->get('/', 'Controller@home');
$route->get('/login', 'Controller@login');
$route->post('/login', 'Controller@login');
$route->get('/expenses', 'Controller@expenses');
//$route->get('/expenses/year', 'expenses');
//$route->post('/add/bill', 'add');
//$route->post('/wuff', 'success');

$route->submit();
//echo '<pre>';
//print_r($route);

