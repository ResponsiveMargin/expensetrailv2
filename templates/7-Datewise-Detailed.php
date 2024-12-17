<?php 
    include_once '../init.php'; 

    // User login check
    if ($getFromU->loggedIn() === false) {
        header('Location: ../index.php');
    }

    include_once 'skeleton.php';
?>

<div class="wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 style="font-family:'Source Sans Pro'; font-size: 1.3em; text-align: center">
                        Expenses incurred between <?php echo date("d-m-Y", strtotime($_POST['dtfrom'])); ?> and <?php echo date("d-m-Y", strtotime($_POST['dtto'])); ?>
                    </h4>    
                </div>
                <div class="card-content">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Desc.</th>
                                <th>Cost</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="chart-facilitate">
                            <?php
                                // Initialize the total expenses variable
                                $total_expenses = 0;
                                $dtexp = $getFromE->dtwise($_SESSION['UserId'], $_POST['dtfrom'], $_POST['dtto']);
                                if ($dtexp !== NULL) {
                                    foreach ($dtexp as $index => $expense) {
                                        // Sum up the total expenses
                                        $total_expenses += $expense->Cost;

                                        // Display individual expenses
                                        echo "<tr>
                                            <td>" . ($index + 1) . "</td>
                                            <td>" . htmlspecialchars($expense->Item) . "</td>
                                            <td>₱ " . htmlspecialchars($expense->Cost) . "</td>
                                            <td>" . date("d-m-Y", strtotime($expense->Date)) . "</td>
                                        </tr>";    
                                    }
                                } else {
                                    echo "<tr><td colspan='4' style='text-align:center;'>No expenses found for this date range.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    
                    <?php if ($dtexp !== NULL): ?>
                        <!-- Display total expenses -->
                        <div style="margin-top: 20px; text-align: center; font-family: 'Source Sans Pro'; font-size: 1.2em;">
                            <strong>Total Expenses: </strong> ₱ <?php echo number_format($total_expenses, 2); ?>
                        </div>
                    <?php endif; ?>
                    <form action="../printing.php" method="post" target="_blank">
    <input type="hidden" name="dtfrom" value="<?php echo $_POST['dtfrom']; ?>">
    <input type="hidden" name="dtto" value="<?php echo $_POST['dtto']; ?>">
    <br><center><button type="submit" class="pressbutton" name="print">Print</button></center>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
