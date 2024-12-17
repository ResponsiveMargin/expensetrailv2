<?php 
    include_once "../init.php";
    include_once '../connection.php';
    
    // User login check
    if (isset($_SESSION['UserId'])) {
      header('Location: 3-Dashboard.php');
      exit();
    }

    if(isset($_POST['register']))
    {
        // Handling file upload
        if(empty($_FILES['inpFile']['name']))
        {
            $target = '../static/images/userlogo.png';  // Default image
        }
        else
        {
            // Generate a unique name for the uploaded image
            $profileImageName = time() .'_'. $_FILES['inpFile']['name'];
            $target = '../static/profileImages/' . $profileImageName;
            move_uploaded_file($_FILES['inpFile']['tmp_name'], $target);  // Save uploaded image
        }
        
        $fullname = $_POST['full_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['password_confirm'];
        $email = $_POST['email'];
        $signupError = "";

        // Sanitize inputs
        $email = $getFromU->checkInput($email);
        $fullname = $getFromU->checkInput($fullname);
        $username = $getFromU->checkInput($username);
        $password = $getFromU->checkInput($password);
        $confirm_password = $getFromU->checkInput($confirm_password);

        // Form validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            $signupError = "Invalid email";
        } 
        elseif (strlen($fullname) > 30 || strlen($fullname) < 2) 
        {
            $signupError = "Name must be between 2-30 characters";
        } 
        elseif (strlen($username) > 30 || strlen($username) < 3) 
        {
            $signupError = "Username must be between 3-30 characters";
        } 
        elseif (strlen($password) < 6) 
        {
            $signupError = "Password too short";
        }
        elseif (strlen($password) > 30) 
        {
            $signupError = "Password too long";
        }
        elseif ($password !== $confirm_password) 
        {
            $signupError = "Passwords do not match";
        }
        else 
        {
            // Check if email or username already exists
            if ($getFromU->checkEmail($email)) 
            {
                $signupError = "Email already registered";
            } 
            elseif ($getFromU->checkUsername($username)) 
            {
                $signupError = "Username already exists";
            }
            else 
            {
                // Create user account
                $user_id = $getFromU->create('user', array(
                    'Email' => $email,
                    'Password' => md5($password),
                    'Full_Name' => $fullname,
                    'Username' => $username,
                    'Photo' => $target,
                    'RegDate' => date("Y-m-d H:i:s")
                ));

                // Store session data and redirect to the dashboard
                $_SESSION['UserId'] = $user_id; 
                $_SESSION['swal'] = "<script>
                    Swal.fire({
                        title: 'Yay!',
                        text: 'Congrats! You are now a registered user',
                        icon: 'success',
                        confirmButtonText: 'Done'
                    })
                </script>";
                header('Location: 3-Dashboard.php');
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../static/images/wallet.png" sizes="16x16" type="image/png">
    <link rel="stylesheet" href="../static/css/2-sign-up.css">
    <title>Expense Trail</title>    
</head>
<body>

    <div class="container">
        <div class="mob-hidden">
            <h1>Create Your Account!</h1>
        </div>

        <div class="img-container">
            <h1>Create Your Account!</h1>
            <img src="../static/images/registration.png" alt="">
        </div>

        <form action="2-sign-up.php" method="post" enctype="multipart/form-data">
            <!-- Image Upload -->
            <div class="image-preview" id="imagePreview">
                <img src="../static/images/userlogo.png" alt="Image Preview" class="image-preview__image" id="profileDisplay">
                <span class="image-preview__default-text"></span>
            </div>
            <label for="imageUpload" class="user-pic-btn" style="cursor: pointer;">Add Photo</label>
            <input type="file" name="inpFile" id="imageUpload" accept="image/*" style="display: none">

            <!-- User details -->
            <div class="group">
                <div class="form-control">
                    <input type="text" name="full_name" id="fullname" minlength="2" maxlength="30" placeholder="Full Name" required>
                </div>

                <div class="form-control">
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>

                <div class="form-control">
                    <input type="text" name="username" id="username" placeholder="Username" minlength="3" maxlength="30" required>
                </div>
                
                <div class="form-control">
                    <input type="password" name="password" id="password" placeholder="Password" minlength="6" maxlength="30" autocomplete="on" required>
                </div>

                <div class="form-control">
                    <input type="password" name="password_confirm" id="confirmpassword" minlength="6" maxlength="30" placeholder="Confirm Password" autocomplete="on" required>
                </div>
            </div>

            <button type="submit" value="Submit" name="register">Complete</button>

            <!-- Error display -->
            <?php  
                if (isset($signupError)) {
                    echo '<div style="color: red;">'.$signupError.'</div>';
                }
            ?>
        </form>
    </div>

</body>
</html>
