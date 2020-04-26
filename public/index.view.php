<?php use Auth\User; ?>
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
                    <?php if (User::auth()) : ?>
                        <li><a href="<?php echo baseUrl(); ?>/logout">Logout</a></li>
                    <?php else : ?>
                        <li><a href="<?php echo baseUrl(); ?>/login">Login</a></li>
                    <?php endif;?>
                </ul>
            </nav>
        </div>
    </div> <!-- page-header -->

    <!-- CONTENT -->
    <div id="page-content" class="content">
        <div class="content-container">
            <?php if(User::auth()) : ?>
            <!-- 
                User is logged in -> USERs PROFILE
             --> 
            <div id="user-container" class="user-container">
                <h2><?php echo User::name();?>s Profil</h2>
                <hr>
            </div>

            <div class="user-content">
                <div class="user-content-container">
                    <h3>Ausgaben in diesem Monat</h3>
                </div>
                <div class="user-content-container">
                    <h3>Noch über für den rest des Monats</h3>
                </div>
            </div>
            

            <?php else: ?>
            <!-- 
                Not logged in!
             --> 
            <h3>Nicht eingeloggt: <a style="color: #ffa604" href="<?php echo baseUrl();?>/login">hier entlang und einloggen</a></h3>
            <?php endif;?>
        </div>
    </div> <!-- page-content -->
    <!-- END CONTENT -->

    <!-- get_footer() -->
    <div id="page-footer" class="footer">
    <div class="footer-title"><a href="http://www.xenadu.de">xendu.de</a></div>
    <div class="footer-content">Visit on GitHub</div>
    </div> <!-- page-footer -->
</body>
</html>