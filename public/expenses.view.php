<?php 
    use Auth\Auth;
    use Db\Mapper\TypeMapper;
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
                        <li><a href="<?php echo baseUrl(); ?>/newlogin">Login</a></li>
                    <?php endif;?>
                </ul>
            </nav>
        </div>
    </div> <!-- page-header -->

    <!-- CONTENT -->
    <div id="page-content" class="content">
        <div class="content-container">
            <?php if (Auth::auth()) : ?>
                <?php
                    $currentDate = new DateTime('now');
                    $currentDateString = $currentDate->format('Y-m-d');
                ?>
            <!-- 
                User is logged in -> USERs PROFILE
             --> 
            <div id="user-container" class="user-container">
            <h1>MyExpenses</h1>

            <div class="input-expenses-container">
                <form method="POST" action="<?php echo baseUrl()?>/expenses/add">
                    <!-- Eingabe: Summe -->
                    <div class="input-fields">
                        <?php if (isset($_SESSION['flash']['sum'])) : ?>
                            <span class="flash-error-msg">
                                <?php echo $_SESSION['flash']['sum'];
                                    unset($_SESSION['flash']['sum']);
                                ?>
                            </span>
                        <?php endif; ?>

                        <label for="sum">Summe</label>
                        <input id="sum" type="number" step="0.01" name="sum" value="20.30">
                    </div> <!-- Summe -->

                    <!-- Eingabe: Ort -->
                    <div class="input-fields">
                        <?php if (isset($_SESSION['flash']['location'])) : ?>
                            <span class="flash-error-msg">
                                <?php echo $_SESSION['flash']['location'];
                                    unset($_SESSION['flash']['location']);
                                ?>
                            </span>
                        <?php endif; ?>
                        <label for="location">Wo?</label>
                        <input id="location" name="location" type="text" maxlength="25" placeholder="Wo habe ich eingekauft? ...">
                    </div> <!-- Ort -->

                    <!-- Eingabe: Typ -->
                    <div class="input-fields">
                        <?php if (isset($_SESSION['flash']['type'])) : ?>
                            <span class="flash-error-msg">
                                <?php echo $_SESSION['flash']['type'];
                                    unset($_SESSION['flash']['type']);
                                ?>
                            </span>
                        <?php endif; ?>

                        <label for="type">Art des Einkaufs?</label>
                        <select id="type" name="type">
                        <?php
                        $typeMapper = new TypeMapper();
                        $typeList = $typeMapper->findAll();
                        foreach ($typeList as $type) :
                            ?>
                            <option value="<?php echo $type->getId(); ?>"><?php echo $type->getName();?></option>
                            <?php
                        endforeach;
                        ?>
                        </select>
                    </div> <!-- Typ -->
                
                    <!-- Eingabe: Datum -->
                    <div class="input-fields">
                        <?php if (isset($_SESSION['flash']['date'])) : ?>
                            <span class="flash-error-msg">
                                <?php echo $_SESSION['flash']['date'];
                                    unset($_SESSION['flash']['date']);
                                ?>
                            </span>
                        <?php endif; ?>
                        <label for="occurred">Wann war der Einkauf?</label>
                        <input type="date" value="<?php echo $currentDateString; ?>" name="occurred" id="occurred">
                    </div>
                    <div class="input-fields">
                        <button type="submit">Eintragen</button>
                    </div> <!-- Datum -->
                    
                </form>
            </div>
                
            </div>
            

            <?php else : ?>
            <!-- 
                Not logged in!
             --> 
            <div>
                <h2>Kein Zugriff</h2>
                <hr>
                <h3>Aber das wird alles noch anders angezeigt</h3>
            </div>
            <?php endif;?>
        </div>
    </div> <!-- page-content -->
    <!-- END CONTENT -->

    <!-- get_footer() -->
    <div id="page-footer" class="footer">
    <div class="footer-title"><a href="http://www.xenadu.de">xenadu.de</a></div>
    <div class="footer-content"><a href="https://github.com/Hypnagokali/xenadu-myexpenses">Visit on GitHub</a></div>
    </div> <!-- page-footer -->
</body>
</html>