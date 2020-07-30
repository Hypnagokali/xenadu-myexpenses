<?php
function baseUrl() {
    include __DIR__ . '/../config/config.php';
    return $baseUrl;
}

function dbConnection() {
    include __DIR__ . '/../config/config.php';
    $connArray = [
        'db_host' => $db_host,
        'db_name' => $db_name,
        'db_user' => $db_user,
        'db_password' => $db_password,
    ];
    return $connArray;
}

function app($config_var = '') {
    switch ($config_var) {
        case 'baseUrl':
            return baseUrl();
        break;
        case 'db':
            return dbConnection();
        break;
        default:
            return false;
    }
}