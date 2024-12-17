<?php 
    include_once "../init.php";
    if ($getFromU->loggedIn() === false) {
        header('Location: ../index.php');
    }
    include_once 'skeleton.php'; 

    $error = ''; // Variable to hold error messages
    $successMessage = ''; // Variable to hold success messages
    $currentBudget = 0; // Variable to hold the current budget

    // Check for existing budget
    $user_id = $_SESSION['UserId'];
    $curr_budget = $getFromB->checkbudget($user_id);
    if ($curr_budget !== NULL) {
        $currentBudget = $curr_budget; // Retrieve the current budget
    }

    if (isset($_POST['enterbudget'])) {
        $budget = $_POST['budget'];

        // Validate the budget input
        if (!is_numeric($budget) || $budget < 0) {
            $error = 'Please enter a valid positive number for your budget.';
        } else {
            // Update the budget by adding the new input
            $newBudget = $currentBudget + floatval($budget);
            
            if ($curr_budget == NULL) {
                $getFromB->setbudget($user_id, $newBudget);
            } else {
                $getFromB->updatebudget($user_id, $newBudget);
            }

            // Set success message
            $successMessage = 'Records Updated Successfully. Your total budget is now ' . $newBudget;
            $currentBudget = $newBudget; // Update the current budget variable
        }
    }
?>

<div class="wrapper">
    <div class="row">
        <div class="col-12 col-m-12 col-sm-12">
            <div class="card">
                <div class="counter" style="height: 40vh; display: flex; align-items: center; justify-content: center;">
                    <form action="" method="post"> 
                        <p style="font-size: 1.4em; color:black; font-family:'Source Sans Pro'">
                            Enter your balance:
                        </p><br>
                        <input type='text' name="budget" class="text-input" style="color:black;font-size: 1.2em;background: rgba(0,0,0,0);text-align: center; border: none; outline: none; border-bottom: 2px solid black;" required/><br><br>
                        <?php if ($error): ?>
                            <div style="color: red; font-size: 1em;"><?php echo $error; ?></div>
                        <?php elseif ($successMessage): ?>
                            <div style="color: green; font-size: 1em;"><?php echo $successMessage; ?></div>
                        <?php endif; ?>
                        <br>
                        <button type="submit" name="enterbudget" class="pressbutton">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
