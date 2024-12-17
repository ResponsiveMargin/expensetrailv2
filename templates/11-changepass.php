<?php 
    include_once "../init.php";

    // User login check
    if ($getFromU->loggedIn() === false) {
        header('Location: ../index.php');
    }

    include_once 'skeleton.php'; 

    // Initialize error array to store validation errors
    $errors = [];

    // Password validation and change
    if (isset($_POST['changepwd'])) {
        // Fetch the user's current password hash from the database
        $old_pass_hash = $getFromU->userData($_SESSION['UserId'])->Password;
        $confirmpass = md5($_POST['oldpass']);

        // Validate input fields
        $oldpass = trim($_POST['oldpass']);
        $newpass = trim($_POST['newpass']);
        $cnewpass = trim($_POST['cnewpass']);

        // Check if old password is correct
        if (empty($oldpass)) {
            $errors['oldpass'] = "Current password cannot be blank";
        } elseif ($confirmpass !== $old_pass_hash) {
            $errors['oldpass'] = "Incorrect current password";
        }

        // Validate new password
        if (empty($newpass)) {
            $errors['newpass'] = "New password cannot be blank";
        } elseif (strlen($newpass) < 6) {
            $errors['newpass'] = "New password must be a minimum of 6 characters long";
        } elseif (strlen($newpass) > 30) {
            $errors['newpass'] = "New password must be a maximum of 30 characters long";
        }

        // Confirm new password
        if (empty($cnewpass)) {
            $errors['cnewpass'] = "Confirm password cannot be blank";
        } elseif ($newpass !== $cnewpass) {
            $errors['cnewpass'] = "The two passwords do not match";
        }

        // If no validation errors, proceed to update password
        if (empty($errors)) {
            $getFromU->update('user', $_SESSION['UserId'], array('Password' => md5($newpass)));
            $success_message = "Password Updated Successfully";
        } else {
            $error_message = "Could Not Change Password";
        }
    }
?>

<div class="wrapper">
    <div class="row">
        <div class="col-12 col-m-12 col-sm-12">
            <div class="card">
                <div class="counter" style="height: 60vh; display: flex; align-items: center; justify-content: center;">
                    <form action="" method="post" id="form">

                        <div class="formcontrol">
                            <label style="font-family: 'Source Sans Pro'; font-size: 1.3em;">Current Password:</label><br>
                            <input type="password" class="text-input" name="oldpass" id="oldpass" value="" required="true" style="padding-top: 10px;"><br>
                            <small style="color: red;"><?php echo isset($errors['oldpass']) ? $errors['oldpass'] : ''; ?></small>
                        </div>

                        <div class="formcontrol">
                            <label style="font-family: 'Source Sans Pro'; font-size: 1.3em;">New Password:</label><br>
                            <input type="password" class="text-input" name="newpass" id="newpass" value="" required="true" style="padding-top: 10px;"><br>
                            <small style="color: red;"><?php echo isset($errors['newpass']) ? $errors['newpass'] : ''; ?></small>
                        </div>

                        <div class="formcontrol">
                            <label style="font-family: 'Source Sans Pro'; font-size: 1.3em;">Re-Type Password:</label><br>
                            <input type="password" class="text-input" name="cnewpass" id="cpass" value="" required="true" style="padding-top: 10px;"><br>
                            <small style="color: red;"><?php echo isset($errors['cnewpass']) ? $errors['cnewpass'] : ''; ?></small>
                        </div>

                        <div><br>
                            <button type="submit" class="pressbutton" name="changepwd">Change Password</button>
                        </div>                              
                    </form>

                    <?php if (isset($success_message)): ?>
                        <div style="color: green; font-family: 'Source Sans Pro';"><?php echo $success_message; ?></div>
                    <?php elseif (isset($error_message)): ?>
                        <div style="color: red; font-family: 'Source Sans Pro';"><?php echo $error_message; ?></div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>
