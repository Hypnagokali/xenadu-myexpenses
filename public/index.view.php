<?php
include 'header.php';
?>

<?php
use Auth\Auth;

$user = null;
if (Auth::auth()) {
    $user = Auth::getUser();
}
?>
    <!-- CONTENT -->
    <div id="page-content" class="content">
        <div class="content-container">
            <?php if (Auth::auth()) : ?>
            <!-- 
                User is logged in -> USERs PROFILE
             --> 
            <div id="user-container" class="user-container">
                <h2>Das Profil von dir! <?php echo $user->getName() . ' ' . $user->getSurname();?></h2>
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
            

            <?php else : ?>
            <!-- 
                Not logged in!
             --> 
            <h3>Nicht eingeloggt: <a style="color: #ffa604" href="<?php echo baseUrl();?>/login">hier entlang und einloggen</a></h3>
            <?php endif;?>
        </div>
    </div> <!-- page-content -->
    <!-- END CONTENT -->

<?php 
include 'footer.php';
?>