<?php 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/side_bar1.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="../JS/sidebar.js" defer></script>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../images\profile.png" alt="account img">
                </span>

                <div class="text header-text">
                    <span class="name"> </span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="admin_dashboard.php">
                            <i onclick="window.location.href='consumer_dashboard.php'" class='bx bx-home icons'></i>
                            <span class="text nav-text"
                                onclick="window.location.href='consumer_dashboard.php'">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="admin_alerts.php">
                            <i onclick="window.location.href='admin_alerts.php'" class='bx bx-bell icons'></i>
                            <span onclick="window.location.href='admin_alerts.php'"
                                class="text nav-text">Alerts</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="consumer_energy.php">
                            <i onclick="window.location.href='consumer_energy.php'" class='bx bx-bolt-circle icons'></i>
                            <span class="text nav-text" onclick="window.location.href='consumer_energy.php'">Energy
                                Consumption</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="consumer_anomalies.php">
                            <i onclick="window.location.href='consumer_anomalies.php'" class='bx bx-stats icons'></i>
                            <span onclick="window.location.href='consumer_anomalies.php'"
                                class="text nav-text">Anomalies</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="houses.php">
                            <i onclick="window.location.href='houses.php'" class='bx bx-building-house icons'></i>
                            <span onclick="window.location.href='houses.php'" class="text nav-text">Houses</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-content">
                <li class="">
                    <a href="index.php">
                        <i onclick="window.location.href='index.php'" class='bx bx-power-off icons'></i>
                        <span onclick="window.location.href='index.php'" class="text nav-text">Logout</span>
                    </a>
                </li>
                <li class="mode">
                    <div class="moon-sun">
                        <i class='bx bx-moon icons moon'></i>
                        <i class='bx bx-sun icons sun'></i>
                    </div>
                    <span class="mode-text text">Dark Mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
    </nav>
</body>

</html>