<?php 
    include_once "init.php";
    
    // Redirect if user is already logged in
    if (isset($_SESSION['UserId'])) {
        header('Location: templates/3-Dashboard.php');
    }

    // Initialize error array to store validation errors
    $errors = [];
    
    // Process form submission
    if (isset($_POST['login']) && !empty($_POST)) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validate username
        if (empty($username)) {
            $errors['username'] = "Username cannot be blank";
        } elseif (strlen($username) <= 2) {
            $errors['username'] = "Minimum length of username: 3 characters";
        }

        // Validate password
        if (empty($password)) {
            $errors['password'] = "Password cannot be blank";
        }

        // If no validation errors, attempt login
        if (empty($errors)) {
            $username = $getFromU->checkInput($username);
            $password = $getFromU->checkInput($password);
            if ($getFromU->login($username, $password) === false) {
                $errors['login'] = "The username or password is incorrect";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="static/images/wallet.png" sizes="16x16" type="image/png">
    <link rel="stylesheet" href="static/css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <title>Expense Trail</title>
</head>
<body>
    <div class="container">
        <div class="mob-hidden">
            <h1>EMS</h1>
        </div>
        <div class="top-heading">
            <h1>Expense Trail</h1>
        </div>
        <form action="index.php" method="post" id="form1">
            <div class="group">
                <div class="form-controller">
                    <i class="fa fa-user-plus u3" aria-hidden="true"></i>
                    <input type="text" name="username" placeholder="Username" id="user1" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
                    <br>
                    <small style="color:red;"><?php echo isset($errors['username']) ? $errors['username'] : ''; ?></small>
                </div>
                <div class="form-controller">
                    <i class="fa fa-key u4" aria-hidden="true"></i>
                    <input type="password" name="password" placeholder="Password" id="pass1" autocomplete="on" required>
                    <br>
                    <small style="color:red;"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></small>
                </div>
            </div>
            <button type="submit" class="sign-in" name="login">Log In</button>
            <br>
            <?php if (isset($errors['login'])): ?>
                <div style="color: red; font-family: 'Source Sans Pro';"><?php echo $errors['login']; ?></div>
            <?php endif; ?>
            
            <div class="new-account">
                <span style="color: rgba(0, 0, 0, 0.54); font-weight: bolder; font-family: 'Source Sans Pro';">Don't have an account?</span> 
                <a href="templates/2-sign-up.php" style="text-decoration: none;"><span style="color: rgba(5, 0, 255, 0.81); font-weight: bolder; font-family: 'Source Sans Pro';">Sign Up Now</span></a>
            </div>
        </form>
        <div class="img-container">
            <img src="static/images/login.png" alt="Login-screen-picture">
        </div>
    </div>
</body>
</html>
