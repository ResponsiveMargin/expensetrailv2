<?php 
    include_once "../init.php";
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
                        Expenses incurred between <?php echo date('F, Y', strtotime($_POST['mthfrom'])); ?> and <?php echo date('F, Y', strtotime($_POST['mthto'])); ?>
                    </h4>    
                </div>
                <div class="card-content">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Cost</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="chart-facilitate1">
                            <?php 
                                // Append "-01" to both month inputs to convert them to full dates
                                $_POST['mthto'] = $_POST['mthto']."-01";
                                $_POST['mthfrom'] = $_POST['mthfrom']."-01";

                                // Fetch monthly expenses
                                $mthexp = $getFromE->mthwise($_SESSION['UserId'], $_POST['mthfrom'], $_POST['mthto']);
                                if ($mthexp !== NULL && count($mthexp) > 0) {
                                    foreach ($mthexp as $index => $expense) {
                                        echo "<tr>
                                            <td>".($index + 1)."</td>
                                            <td>".htmlspecialchars($expense->Item)."</td>
                                            <td>₱ ".htmlspecialchars($expense->Cost)."</td>
                                            <td>".date("d-m-Y", strtotime($expense->Date))."</td>
                                        </tr>";	
                                    }
                                } else {
                                    echo "<tr><td colspan='4' style='text-align:center;'>No expenses found for this date range.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
