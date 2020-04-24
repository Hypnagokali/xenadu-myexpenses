<?php
/**
 * index.php
 * 
 * Bootstrap file for the app
 * 
 * @author Stefan Simon <stefan.simon@lionysos.com>
 * 
 */

use Controller\Controller;

require_once 'src/Route.php';
require_once 'src/View.php';
require_once 'src/Controller.php';


$route = new Route();
$controller = new Controller();

$route->get('/', 'home');
$route->get('/expenses', 'expenses');
$route->get('/expenses/year', 'expenses');
$route->post('/add/bill', 'add');
$route->post('/wuff', 'success');

$route->submit();
echo '<pre>';
print_r($route);

