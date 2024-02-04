<?php
include 'DataBase.php';
session_start();

if (isset($_SESSION['Consumer_ID'])) {

    
$consumerinfo = "SELECT * from Consumer INNER JOIN House ON Consumer.Consumer_ID=House.Consumer_ID  WHERE Consumer.Consumer_ID =241866";
$houseinfo = "SELECT * from Anomaly INNER JOIN House ON Anomaly.House_ID=House.House_ID  WHERE Consumer_ID =241866";

$cresult = mysqli_query($conn, $consumerinfo);
$aresult = mysqli_query($conn, $houseinfo);

if (!$cresult) {
    die('Error executing query: ' . mysqli_error($conn));
}

$crow = mysqli_fetch_assoc($cresult);
$arow = mysqli_fetch_assoc($aresult);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dash-nav.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="sidebar.js" defer></script>
    <title>Consumer Dashboard</title>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="./images/profile.png" alt="account img">
                </span>

                <div class="text header-text">
                    <span class="name">abdullah</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-home icons'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-bell icons'></i>
                            <span class="text nav-text">Alerts</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-bolt-circle icons'></i>
                            <span class="text nav-text">Energy Consumption</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-stats icons'></i>
                            <span class="text nav-text">Anomalies</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-building-house icons'></i>
                            <span class="text nav-text">House Information</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-content">
                <li class="">
                    <a href="#">
                        <i onclick="window.location.href='//localhost/ECAD/Landing_Page.php'" class='bx bx-power-off icons'></i>
                        <span onclick="window.location.href='//localhost/ECAD/Landing_Page.php'" class="text nav-text">Logout</span>
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

    <section class="home">
        <div class="text">Dashboard</div>
        <p>House ID: <?php echo $crow['House_ID']; ?></p>
    <p>Streat_Name: <?php echo $crow['Streat_Name']; ?></p>
    <p>City: <?php echo $crow['City']; ?></p>
    <p>Building_Number: <?php echo $crow['Building_Number']; ?></p>
    <p>District: <?php echo $crow['District']; ?></p>
    <p>Postal_Code: <?php echo $crow['Postal_Code']; ?></p>
    <p>EnergyUnitNumber: <?php echo $crow['EnergyUnitNumber']; ?></p>

    <p>Anomaly_ID: <?php echo $arow['Anomaly_ID']; ?> Timestamp: <?php echo $arow['Timestamp'];?> Consumptions_value: <?php  echo $arow['Consumptions_value']; ?> </p>

    </section>
 
</body>

</html>