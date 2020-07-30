<?php
include 'header.php';

use Auth\Auth;
?>
    <!-- CONTENT -->
    <div id="page-content" class="content">
        <div class="content-container">
            <?php if (Auth::auth()) : ?>
            <!-- 
                User is logged in -> USERs PROFILE
             --> 
            <div id="user-container" class="user-container">
                <h2>User ist bereits eingeloggt o.Ô</h2>
                <hr>
            </div>
            

            <?php else : ?>
            <!-- 
                Not logged in!
             --> 
            <h2>Login</h2>
                <?php
                if (isset($_SESSION['flash']['login'])) :
                    ?>
                <div class="flash-error-msg">
                        <?php
                        echo $_SESSION['flash']['login'];
                        unset($_SESSION['flash']['login']);
                        ?>
                </div>
                    <?php
                endif;
                ?>
            <div>
                <form action ="login" method="POST">
                    <label for="email">E-Mail:</label>
                    <input type="text" name="email" id="email" placeholder="E-Mail" />
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" />
                    <input type="submit" value="Login" />
                </form>
            </div>
            <?php endif;?>
        </div>
    </div> <!-- page-content -->
    <!-- END CONTENT -->

<?php include 'footer.php'; ?>