<?php
$errors = array();
session_start();
include 'DB/DataBase.php';
include 'side-bar.php'; 

$anomalyinfo = "SELECT * FROM train WHERE  building_id = 107 AND  AnomalyStatus = 'Pending' ";
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
    <link rel="stylesheet" href="../css/info_card.css">
    <title>Admin Confirmation</title>
</head>

<body>
    <section class="home">
        <div class="text">Anomaly</div>
        <div class="container">
           
                        <div class="card">
                <p>building_id: <?php echo $arow['building_id']; ?></p>
                <p>Timestamp: <?php echo $arow['timestamp']; ?></p>
                <p>meter_reading: <?php echo $arow['meter_reading']; ?></p>
                <p>AnomalyStatus: <?php echo $arow['AnomalyStatus']; ?></p>
            </div>
        </div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <button type="submit" class="button" name="confirm">Confirm</button>
            <button type="submit" class="button" name="reject">Reject</button>
        </form>
    </section>
</body>

</html>
