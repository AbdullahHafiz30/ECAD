<?php

session_start();
include '../side-bar.php';
include '../DB/DataBase.php';

header("refresh: 5");
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a checkbox is selected
    if (isset($_POST['delete'])) {
        foreach ($_POST['delete'] as $deleteId) {
            $deleteId = mysqli_real_escape_string($conn, $deleteId);
            $deleteQuery = "DELETE FROM `anomaly` WHERE `Anomaly_ID` = '$deleteId'";
            mysqli_query($conn, $deleteQuery);
        }
        // Redirect to refresh the page
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}

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
    <script>
        function deleteRows() {
            document.getElementById('deleteForm').submit();
        }
    </script>
</head>

<body>
    <div class="center-table">
        <h1>Alerts</h1><br><br>
        <form id="deleteForm" method="POST">
            <table class="content-table">
                <thead>
                    <tr>
                        <th scope="col">Anomaly ID </th>
                        <th scope="col">Timestamp </th>
                        <th scope="col">Energy Unit Number </th>
                        <th scope="col">Consumption Value </th>
                        <th scope="col">Done</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['Anomaly_ID'] ?></td>
                            <td><?php echo $row['Timestamp'] ?></td>
                            <td><?php echo $row['Energy_UnitNumber'] ?></td>
                            <td><?php echo $row['Consumptions_value'] ?></td>
                            <td><input type="checkbox" name="delete[]" value="<?php echo $row['Anomaly_ID'] ?>" onclick="deleteRows()"></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>