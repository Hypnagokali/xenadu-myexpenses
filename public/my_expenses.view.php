<?php
include 'header.php';

use Controller\MyExpensesController;
use Model\SpecialTypes\ExpensesStrings;

?>

    <!-- CONTENT -->
    <div id="page-content" class="content">
        <div class="content-container">
            <div id="user-container" class="user-container">
            <h1>Ausgaben <span class="sub-header">in diesem Monat</span></h1>

            <?php
                $controller = MyExpensesController::getInstance();
                $expensesList = $controller->myExpensesData();
            ?>

            <table class="expenses-table">
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Ausgaben</th>
                    <th>Wo?</th>
                    <th>Typ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $alltogetherSum = 0;
                foreach ($expensesList as $expenses) :
                    $expensesStrings = new ExpensesStrings($expenses);
                    $alltogetherSum += $expenses->getSum();
                    ?>
                <tr>
                <td><?php echo $expensesStrings->getOccurredAtAsString('d.m'); ?></td>
                <td>
                    <?php
                    echo $expensesStrings->getSumEuroString();
                    ?>
                </td>
                <td><?php echo $expenses->getLocation(); ?></td>
                <td><?php echo $expenses->getType()->getName(); ?></td>
                </tr>
                    <?php
                endforeach;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Summe</th>
                    <th>
                        <?php
                        echo ExpensesStrings::convertToEuroString($alltogetherSum);
                        ?>
                    </th>
                </tr>
            </tfoot>
            </table>
                
            </div>
        </div>
    </div> <!-- page-content -->
    <!-- END CONTENT -->


<?php
include 'footer.php';
?>