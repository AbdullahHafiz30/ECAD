<?php
$errors = array();
session_start();
include '../DB/DataBase.php';
include '../side-bar.php'; 

$anomalyinfo = "SELECT * FROM train WHERE  building_id = 107 AND  AnomalyStatus = 'Confirmed' ";
$aresult = mysqli_query($conn, $anomalyinfo);
$arow = mysqli_fetch_assoc($aresult);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['confirm'])) {
        // Perform the update query to change AnomalyStatus to "Confirmed"
        $sql = "UPDATE train SET AnomalyStatus = 'Confirmed' WHERE building_id = 107 AND timestamp = '" . $arow['timestamp'] . "'";
        mysqli_query($conn, $sql);
        // You can add additional logic or redirect the user after the update
    } elseif (isset($_POST['reject'])) {
        // Perform the update query to change AnomalyStatus to "Rejected"
        $sql = "UPDATE train SET AnomalyStatus = 'Rejected' WHERE building_id = 107 AND timestamp = '" . $arow['timestamp'] . "'";
        mysqli_query($conn, $sql);
        // You can add additional logic or redirect the user after the update
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="info_card.css">
    <script src="sidebar.js" defer></script>
    <title>Anomaly Information</title>
</head>

<body>
    <section class="home">
        <div class="text">Anomaly</div>
        <div class="container">
            <style>
        .powerbi-container {
            margin-bottom: 200px; 
            margin-left: 300px; 
        }
        </style>
               <div class="powerbi-container">
               <iframe title="CBuilding107" width="900" height="500" src="https://app.powerbi.com/reportEmbed?reportId=99436f89-1d6d-4878-9325-4b5abb0051a6&autoAuth=true&ctid=13a8d02d-59f3-416a-8231-b3080e639cad" frameborder="0" allowFullScreen="true"></iframe>   
                     </div>
                        <div class="card">
                <p>building_id: <?php echo $arow['building_id']; ?></p>
                <p>Timestamp: <?php echo $arow['timestamp']; ?></p>
                <p>meter_reading: <?php echo $arow['meter_reading']; ?></p>
                <p>AnomalyStatus: <?php echo $arow['AnomalyStatus']; ?></p>
            </div>
        </div>
    </section>
</body>

</html>
