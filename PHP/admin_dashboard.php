<?php
$errors = array();
session_start();
include 'DB/DataBase.php';
include 'side-bar.php';

$sql = "SELECT * FROM train LIMIT 1000";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Check if data is empty or not
if (!$data) {
    echo "No data retrieved or error occurred.";
} else {
    $building_ids_js = '[';
    $meter_readings_js = '[';
    $timestamps_js = '[';
    
    foreach ($data as $row) {
        // Append building_id to building_ids_js
        $building_ids_js .= '"' . $row['building_id'] . '",';
        // Append meter_reading to meter_readings_js
        $meter_readings_js .= $row['meter_reading'] . ',';
        // Append timestamp to timestamps_js
        $timestamps_js .= '"' . $row['timestamp'] . '",';
    }
    
    // Remove trailing commas
    $building_ids_js = rtrim($building_ids_js, ',') . ']';
    $meter_readings_js = rtrim($meter_readings_js, ',') . ']';
    $timestamps_js = rtrim($timestamps_js, ',') . ']';
    
}

$sql = "SELECT * FROM train"; 
$result = mysqli_query($conn, $sql);
$train = mysqli_fetch_assoc($result)

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\admin\admin-dash.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <title>Admin Dashboard</title>
</head>
<body>
<section class="home">
    <div class="graph">
        <canvas id="myChart"></canvas>
        <canvas id="myChart2"></canvas>
    </div>
    
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
                        borderColor: '#10870e',
                        tension: 0.1
                    }]
                }
            });
    </script>
    <script>
// Render bar chart using Chart.js
var ctx = document.getElementById('myChart2').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // Change the chart type to 'bar'
    data: {
        labels: <?php echo $timestamps_js; ?>,
        datasets: [{
            label: 'Meter Readings',
            data: <?php echo $meter_readings_js; ?>,
            backgroundColor: '#10870e', // Set background color for bars
            borderColor: '#10870e',
            borderWidth: 1, // Set border width for bars
            barThickness: 5 // Set the thickness of the bars
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true // Start y-axis at zero
            }
        }
    }
});

    </script>
<section>

</body>

</html>