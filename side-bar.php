<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dash-nav.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Document</title>
</head>
<body>
<nav class="sidebar close">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="./images/profile.png" alt="account img">
            </span>

            <div class="text header-text">
                <span class="name">   </span>
            </div>
        </div>

        <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
        <div class="menu">
            <ul class="menu-links">
                <li class="nav-link">
                    <a href="#">
                        <i onclick="window.location.href='consumer_dashboard.php'" class='bx bx-home icons'></i>
                        <span class="text nav-text" onclick="window.location.href='consumer_dashboard.php'">Dashboard</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="#">
                        <i onclick="window.location.href='consumer_alerts.php'" class='bx bx-bell icons'></i>
                        <span onclick="window.location.href='consumer_alerts.php'" class="text nav-text">Alerts</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="#">
                        <i onclick="window.location.href='consumer_energy.php'" class='bx bx-bolt-circle icons'></i>
                        <span class="text nav-text" onclick="window.location.href='consumer_energy.php'">Energy Consumption</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="#">
                        <i onclick="window.location.href='consumer_anomalies.php'" class='bx bx-stats icons'></i>
                        <span onclick="window.location.href='consumer_anomalies.php'" class="text nav-text">Anomalies</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="#">
                        <i onclick="window.location.href='consumer_house.php'" class='bx bx-building-house icons'></i>
                        <span onclick="window.location.href='consumer_house.php'" class="text nav-text">Houses</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="bottom-content">
            <li class="">
                <a href="#">
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