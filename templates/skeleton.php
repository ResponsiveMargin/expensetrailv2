<?php
    include_once "../init.php";
    
    // Fetch the profile picture
    $pic = $getFromU->Photofetch($_SESSION['UserId']);
    $pic = '"'. $pic . '"';

    // Handle theme switching
    if (isset($_GET['switchTheme'])) {
        $currentTheme = $_COOKIE['theme'] ?? 'light';
        $newTheme = ($currentTheme === 'light') ? 'dark' : 'light';
        setcookie('theme', $newTheme, time() + (86400 * 30), "/");
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Load theme from cookie
    $theme = $_COOKIE['theme'] ?? 'light';

    // Handle sidebar collapse/expand state
    if (isset($_GET['collapseSidebar'])) {
        $collapsed = $_COOKIE['sidebar'] ?? 'expanded';
        $newState = ($collapsed === 'expanded') ? 'collapsed' : 'expanded';
        setcookie('sidebar', $newState, time() + (86400 * 30), "/");
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $sidebarState = $_COOKIE['sidebar'] ?? 'expanded';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../static/images/expenseic.png" sizes="16x16" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="../static/css/skeleton.css">
    <link rel="stylesheet" href="../static/css/11-changepass.css">
    <link rel="stylesheet" href="../static/css/7-Datewise.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../static/css/yearpicker.css">
    <link rel="stylesheet" href="../static/css/6-Manage-Expenses.css">
    
    <title>Expense Trail</title>

    <style>
        body.light {
            background-color: #fff;
            color: #000;
        }
        body.dark {
            background-color: #333;
            color: #fff;
        }
        .collapsed .sidebar {
            width: 60px;
        }
        .expanded .sidebar {
            width: 80px;
        }
        .collapsed {
            display: none;
        }
        .dropdown-menu {
            display: none;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .sidebar-nav .sidebar-nav-item {
            list-style: none;
        }
        .sidebar-nav .sidebar-nav-item a {
            text-decoration: none;
        }
    </style>
</head>

<body class="<?php echo $theme . ' ' . $sidebarState; ?> overlay-scrollbar">
    <!-- Navbar -->
    <div class="navbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <!-- <a class='nav-link' href="?collapseSidebar=true">
                    <i class="fas fa-bars"></i>
                </a> -->
            </li>
            <li class="nav-item">
                <img src="../static/images/expenseic.png" alt="" class="logo">
            </li>
        </ul>
        <h1 class="navbar-text">Expense Trail</h1>
        <ul class="navbar-nav nav-right">
            <li class="nav-item">
                <div class="avt dropdown">
                    <img src=<?php echo $pic ?> alt="" class="dropdown-toggle">
                    <ul id="user-menu" class="dropdown-menu">
                        <li class="dropdown-menu-item">
                            <a href="10-Profile.php" class="dropdown-menu-link">
                                <div>
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="dropdown-menu-item">
                            <a href="logout.php" class="dropdown-menu-link">
                                <div>
                                    <i class="fas fa-sign-out-alt"></i>
                                </div>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <!-- end navbar -->

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="3-Dashboard.php" class="sidebar-nav-link">
                    <div>
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-nav-item">
                <a href="4-Set-Budget.php" class="sidebar-nav-link">
                    <div>
                        <i class="fas fa-coins"></i>
                    </div>
                    <span>Cash Entry</span>
                </a>
            </li>

            <li class="sidebar-nav-item">
                <a href="4-set-accounts.php" class="sidebar-nav-link">
                    <div>
                        <i class="fas fa-book"></i>
                    </div>
                    <span>Set Accounts</span>
                </a>
            </li>

            <!-- Displaying Expense Entry and Expense List -->
            <li class="sidebar-nav-item">
                <a href="5-Add-Expenses.php" class="sidebar-nav-link">
                    <div>
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </div>
                    <span>Expense Entry</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="6-Manage-Expenses.php" class="sidebar-nav-link">
                    <div>
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </div>
                    <span>Expense List</span>
                </a>
            </li>

            <!-- Displaying Datewise Report -->
            <li class="sidebar-nav-item">
                <a href="7-Datewise.php" class="sidebar-nav-link">
                    <div>
                        <i class="fas fa-calendar-day" aria-hidden="true"></i>
                    </div>
                    <span>Expense History</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- end sidebar -->

    <!-- Main Content -->
    <!-- Your main content will go here -->
    <!-- end main content -->

    <!-- Switch Theme Button -->
    <a href="?switchTheme=true" class="theme-switch">Switch Theme</a>
</body>
</html>
