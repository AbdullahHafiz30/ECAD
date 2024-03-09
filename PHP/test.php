<?php
include 'DB\DataBase.php';

// Fetch data from the database
$sql = "SELECT * FROM train LIMIT 10";
$result = mysqli_query($conn, $sql);

// Check if the query executed successfully
if (!$result) {
    echo "Error occurred while fetching data: " . mysqli_error($conn);
} else {
    // Check if data is empty or not
    if (mysqli_num_rows($result) == 0) {
        echo "No data retrieved.";
    } else {
        $building_id = array();
        $timestamp = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $building_id[] = $row["building_id"];
            $timestamp[] = $row["timestamp"];
        }
        
    }
}

// Close the database connection
mysqli_close($conn);

//     // Initialize JavaScript array strings
//     $building_ids_js = '[';
//     $meter_readings_js = '[';

//     // Loop through the data and construct JavaScript arrays
//     foreach ($data as $row) {
//         // Append building_id to building_ids_js
//         $building_ids_js .= $row['building_id'] . ',';
//         // Append meter_reading to meter_readings_js
//         $meter_readings_js .= $row['meter_reading'] . ',';
//     }

//     // Remove trailing commas
//     $building_ids_js = rtrim($building_ids_js, ',') . ']';
//     $meter_readings_js = rtrim($meter_readings_js, ',') . ']';
// 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <style>
        div{
            height: 600px;
            width: 600px;
        }
    </style>
    <h1>Data Visualization</h1>
    <div>
        <canvas id="myChart"></canvas>
    </div>
<style></style>
<script>
    const building_id = <?php echo json_encode($building_id);?>;
    const timestamp = <?php echo json_encode($timestamp);?>;
    const data = {
        labels: building_id,
            datasets: [{
                label: '# of Votes',
                data: building_id,
                borderWidth: 1
            }]
    };

    const config = {
        type: 'bar',
        data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );

  
</script>

</body>
</html>