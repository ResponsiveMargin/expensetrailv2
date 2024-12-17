<?php  
    include_once "../init.php";
    if ($getFromU->loggedIn() === false) {
        header('Location: ../index.php');
    }

    $error = '';
    if(isset($_POST['mthsubmit'])) {
        $mthfrom = $_POST['mthfrom'];
        $mthto = $_POST['mthto'];

        // Validate the date range
        if (strtotime($mthfrom) > strtotime($mthto)) {
            $error = "Date Range Invalid";
        } else {
            header("Location: 8-Monthly-Detailed.php");
            exit();
        }
    }

    include_once 'skeleton.php'; 	
?>

<div class="wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="counter" style="display: flex; align-items: center; justify-content: center;">
                    <form action="8-Monthly-Detailed.php" method="post" id="mthform">
                        <h1 style="display: block; font-family: 'Source Sans Pro'">Monthwise Expense Report</h1>
                        <div class="mthcontrol">
                            <label style="font-family: 'Source Sans Pro'; font-size: 1.3em;">From:</label><br>
                            <input class="text-input" type="month" id='mthfrom' name="mthfrom" required style="width: 100%; padding-top: 8px;"><br><br>
                            <small style="color:red;"><?php echo $error; ?></small>
                        </div>
                        <div class="mthcontrol">
                            <label style="font-family: 'Source Sans Pro'; font-size: 1.3em;">To:</label><br>
                            <input class="text-input" type="month" id="mthto" name="mthto" required style="width: 100%; padding-top: 8px;"><br><br>
                            <small style="color:red;"><?php echo $error; ?></small>        
                        </div>									

                        <div><br>
                            <button type="submit" class="pressbutton" name="mthsubmit">Submit</button>
                        </div>								                            
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
