<?php
use Auth\Auth;
use Http\Redirect;

if (!Auth::auth()) {
    $_SESSION['flash']['login'] = 'Erst einloggen, dann weiter';
    Redirect::to('/login');
}
?>
<!-- get_header() -->
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo baseUrl(); ?>/public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&display=swap" rel="stylesheet">
    <title>Xenadu - MyExpenses</title>
</head>
<body>
    <div id="page-header" class="page">
        <div class="header">
            <h1>xenadu.de <span class="sub"> | MyExpenses</span></h1>
            <nav class="nav">
                <ul>
                    <li><a href="<?php echo baseUrl(); ?>">Home</a></li>
                    <li><a href="<?php echo baseUrl(); ?>/expenses">Ausgaben</a></li>
                    <?php if (Auth::auth()) : ?>
                        <li><a href="<?php echo baseUrl(); ?>/logout">Logout</a></li>
                    <?php else : ?>
                        <li><a href="<?php echo baseUrl(); ?>/login">Login</a></li>
                    <?php endif;?>
                </ul>
            </nav>
        </div>
    </div> <!-- page-header -->