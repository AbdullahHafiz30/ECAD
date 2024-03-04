<?php
include 'DB\DataBase.php';

// Fetch data from the database
$sql = "SELECT * FROM train LIMIT 1000";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Check if data is empty or not
if (!$data) {
    echo "No data retrieved or error occurred.";
} else {
    // Initialize JavaScript array strings
    $building_ids_js = '[';
    $meter_readings_js = '[';

    // Loop through the data and construct JavaScript arrays
    foreach ($data as $row) {
        // Append building_id to building_ids_js
        $building_ids_js .= $row['building_id'] . ',';
        // Append meter_reading to meter_readings_js
        $meter_readings_js .= $row['meter_reading'] . ',';
    }

    // Remove trailing commas
    $building_ids_js = rtrim($building_ids_js, ',') . ']';
    $meter_readings_js = rtrim($meter_readings_js, ',') . ']';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body>
    <h1>Data Visualization</h1>
<canvas id="myChart"></canvas>
<style></style>
    <script>
        // Render chart using Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo $building_ids_js; ?>,
                datasets: [{
                    label: 'Meter Readings',
                    data: <?php echo $meter_readings_js; ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    tension: 0.1
                }]
            }
        });
    </script>
</body>
</html>