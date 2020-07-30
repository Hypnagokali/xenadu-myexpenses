<?php 
    include 'header.php';
    use Auth\Auth;
    use Db\Mapper\TypeMapper;
?>
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
                    <?php
                    if (isset($_SESSION['flash']['success'])) :
                        ?>
                        <h3 class="success"><?php echo $_SESSION['flash']['success']?></h3>
                        <?php
                        unset($_SESSION['flash']['success']);
                    endif;
                    ?>
                <form autocomplete="off" method="POST" action="<?php echo baseUrl()?>/expenses/add">
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

<?php include 'footer.php'; ?>