<?php 

session_start();
include 'side-bar.php';
include 'DataBase.php';

header("refresh: 5");
$queryAnomaly = "SELECT * FROM `anomaly`";
$result = mysqli_query($conn, $queryAnomaly);

$conn->close();

?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style.css">
    <title>Alerts page</title>
</head>

<body>
    <div class="center-table">
        <h1>Alerts</h1><br><br>
        <table class="content-table">
            <thead>
                <tr>
                    <th scope="col">Anomaly ID </th>
                    <th scope="col">Timestamp </th>
                    <th scope="col">Energy Unit Number </th>
                    <th scope="col">Consumption Value </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>

                        <td><?php echo $row['Anomaly_ID'] ?></td>
                        <td><?php echo $row['Timestamp'] ?></td>
                        <td><?php echo $row['Energy_UnitNumber'] ?></td>
                        <td><?php echo $row['Consumptions_value'] ?></td>


                </tr>
            <?php
                    }

            ?>
            </tbody>
        </table>
    </div>
</body>

</html>