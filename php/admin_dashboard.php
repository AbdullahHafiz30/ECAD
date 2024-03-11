<?php
$errors = array();
session_start();
include 'DB/DataBase.php';
include 'admin_side-bar.php';

// Fetch data from the database
$sql = "SELECT * FROM train where building_id = 149 LIMIT 100";
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\admin\admin-dash1.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <title>Admin Dashboard</title>
</head>

<body>
    <section class="home">
        <div class="chart">
            <div class="lineChart">
                <canvas id="lineChart"></canvas>
            </div>
            <div class="barChart">
                <canvas id="barChart"></canvas>
            </div>

            <script>
                const meter_reading = <?php echo json_encode($meter_reading); ?>;
                const timestamp = <?php echo json_encode($timestamp); ?>;
                const anomaly = <?php echo json_encode($anomaly); ?>;
                const pointColors = anomaly.map(a => a == 1 ? 'red' : 'green');

                var data = {
                    labels: timestamp,
                    datasets: [{
                        label: '# of Votes',
                        data: meter_reading,
                        borderWidth: 4,
                        borderColor: '#129c10',
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

                var config = {
                    type: 'line',
                    alignToPixels: true,
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

                var myChart = new Chart(
                    document.getElementById('lineChart'),
                    config
                );

                var data = {
                    labels: timestamp,
                    datasets: [{
                        label: '# of Votes',
                        data: meter_reading,
                        borderWidth: 4,
                        borderColor: '#129c10',
                        backgroundColor: '#ffffff',
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

                var config = {
                    type: 'bar',
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

                var myChart = new Chart(
                    document.getElementById('barChart'),
                    config
                );
            </script>

        </div>

        <section>

</body>

</html>