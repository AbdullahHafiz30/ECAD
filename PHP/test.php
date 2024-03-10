<?php
include 'DB\DataBase.php';

// Fetch data from the database
$sql = "SELECT * FROM train where building_id = 149 LIMIT 50";
$result = mysqli_query($conn, $sql);

// Check if the query executed successfully
if (!$result) {
    echo "Error occurred while fetching data: " . mysqli_error($conn);
} else {
    // Check if data is empty or not
    if (mysqli_num_rows($result) == 0) {
        echo "No data retrieved.";
    } else {
        $meter_reading = array();
        $timestamp = array();
        $anomaly = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $meter_reading[] = $row["meter_reading"];
            $timestamp[] = $row["timestamp"];
            $anomaly[] = $row["anomaly"];
        }
        
    }
}

// Close the database connection
mysqli_close($conn);

//     // Initialize JavaScript array strings
//     $meter_readings_js = '[';
//     $meter_readings_js = '[';

//     // Loop through the data and construct JavaScript arrays
//     foreach ($data as $row) {
//         // Append meter_reading to meter_readings_js
//         $meter_readings_js .= $row['meter_reading'] . ',';
//         // Append meter_reading to meter_readings_js
//         $meter_readings_js .= $row['meter_reading'] . ',';
//     }

//     // Remove trailing commas
//     $meter_readings_js = rtrim($meter_readings_js, ',') . ']';
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
            height: 700px;
            width: 700px;
        }
    </style>
    <h1>Data Visualization</h1>
    <div class = "linegraph">
        <canvas id="myChart"></canvas>
    </div>
<script>
    const meter_reading = <?php echo json_encode($meter_reading);?>;
    const timestamp = <?php echo json_encode($timestamp);?>;
    const anomaly = <?php echo json_encode($anomaly);?>;
    const pointColors = anomaly.map(data => data == 1 ? 'red' : 'green');

    const data = {
        labels: timestamp,
            datasets: [{
                label: '# of Votes',
                data: meter_reading,
                borderWidth: 4,
                borderColor: '#10870e',
                backgroundColor: '#f6f5ff',
                borderJoinStyle: 'round',
                cubicInterpolationMode: 'monotone',
                pointHoverRadius: 6,
                pointStyle: 'circle',
                pointRadius: 1,
                spanGaps: true,
                pointBackgroundColor: pointColors,
                pointBorderColor: pointColors
            }]
    };

    const config = {
        type: 'line',
        data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            transitions: {
            show: {
                animations: {
                x: {
                    from: 0
                },
                y: {
                    from: 0
                }
                }
            },
            hide: {
                animations: {
                x: {
                    to: 0
                },
                y: {
                    to: 0
                }
                }
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