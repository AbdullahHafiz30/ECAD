<?php
$errors = array();
session_start();
include 'DB/DataBase.php';
include 'side-bar.php';
// Fetch data from the database
$sql = "SELECT *
FROM train
WHERE timestamp >= '2016-12-30 00:00:00' 
AND timestamp <= '2016-12-30 23:00:00' 
AND building_id = 181
ORDER BY timestamp;";
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
        <div class="dropdown">
            <div class="select">
                <span class="selected">Daily</span>
                <div class="caret"></div>
            </div>
            <ul class="intervalMenu">
                <li class="active">Daily</li>
                <li>Monthly</li>
                <li>Yearly</li>
            </ul>
        </div>


        <div class="chart">


            <div class="lineChart">
                <canvas id="lineChart"></canvas>
            </div>
            <div class="barChart">
                <canvas id="barChart"></canvas>
            </div>

            <script>
                var meter_reading = <?php echo json_encode($meter_reading); ?>;
                var timestamp = ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'];
                var anomaly = <?php echo json_encode($anomaly); ?>;
                var pointColors = anomaly.map(a => a == 1 ? 'red' : '#046902');

                var data = {
                    labels: timestamp,
                    datasets: [{
                        label: 'Meter Reading',
                        data: meter_reading,
                        borderWidth: 4,
                        borderColor: '#10870e',
                        backgroundColor: '#10870e',
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

                var lineChart = new Chart(
                    document.getElementById('lineChart'),
                    config
                );

                data = {
                    labels: timestamp,
                    datasets: [{
                        label: 'Meter Reading',
                        data: meter_reading,
                        borderWidth: 4,
                        borderColor: '#10870e',
                        backgroundColor: '#abd4ab',
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

                config = {
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

                const barChart = new Chart(
                    document.getElementById('barChart'),
                    config
                );

                const dropdowns = document.querySelectorAll('.dropdown');

                dropdowns.forEach(dropdown => {
                    const select = dropdown.querySelector('.select');
                    const caret = dropdown.querySelector('.caret');
                    const intervalMenu = dropdown.querySelector('.intervalMenu');
                    const options = dropdown.querySelectorAll('.intervalMenu li');
                    const selected = dropdown.querySelector('.selected');

                    select.addEventListener('click', () => {
                        select.classList.toggle('select-clicked');
                        caret.classList.toggle('caret-rotate');
                        intervalMenu.classList.toggle('intervalMenu-open');

                    });
                    options.forEach(option => {
                        option.addEventListener('click', () => {
                            selected.innerText = option.innerText;
                            if (option.innerText == 'Daily') {
                                <?php
                                $sql = "SELECT *
                                FROM train
                                WHERE timestamp >= '2016-12-31 00:00:00' 
                                AND timestamp <= '2016-12-31 23:00:00' 
                                AND building_id = 181
                                ORDER BY timestamp";
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
                                        $anomaly = array();
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $meter_reading[] = $row["meter_reading"];
                                            $anomaly[] = $row["anomaly"];
                                        }
                                    }
                                }
                                ?>

                                meter_reading = <?php echo json_encode($meter_reading); ?>;
                                timestamp = ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'];
                                anomaly = <?php echo json_encode($anomaly); ?>;
                                pointColors = anomaly.map(a => a == 1 ? 'red' : 'green');

                                lineChart.data.datasets[0].data = meter_reading;
                                lineChart.data.labels = timestamp;
                                lineChart.data.datasets[0].pointBackgroundColor = pointColors;
                                lineChart.data.datasets[0].pointBorderColor = pointColors;
                                lineChart.data.datasets[0].borderWidth = 4;
                                lineChart.update();

                                barChart.data.datasets[0].data = meter_reading;
                                barChart.data.labels = timestamp;
                                barChart.data.datasets[0].pointBackgroundColor = pointColors;
                                barChart.data.datasets[0].pointBorderColor = pointColors;
                                barChart.update();

                            } else if (option.innerText == 'Monthly') {
                                <?php
                                $sql = "SELECT
                                DATE(timestamp) AS date,
                                SUM(meter_reading) AS total_meter_reading,
                                MAX(anomaly) AS anomaly
                            FROM train
                            WHERE timestamp >= '2016-12-01 00:00:00' 
                                AND timestamp <= '2016-12-31 23:59:59' 
                                AND building_id = 181
                            GROUP BY date
                            ORDER BY date";
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
                                        $anomaly = array();
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $meter_reading[] = $row["total_meter_reading"];
                                            $anomaly[] = $row["anomaly"];
                                        }
                                    }
                                }
                                ?>

                                meter_reading = <?php echo json_encode($meter_reading); ?>;
                                timestamp = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14',
                                    '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'
                                ];
                                anomaly = <?php echo json_encode($anomaly); ?>;
                                pointColors = anomaly.map(a => a == 1 ? 'red' : 'green');

                                lineChart.data.datasets[0].data = meter_reading;
                                lineChart.data.labels = timestamp;
                                lineChart.data.datasets[0].pointBackgroundColor = pointColors;
                                lineChart.data.datasets[0].pointBorderColor = pointColors;
                                lineChart.data.datasets[0].borderWidth = 3;
                                lineChart.update();

                                barChart.data.datasets[0].data = meter_reading;
                                barChart.data.labels = timestamp;
                                barChart.data.datasets[0].pointBackgroundColor = pointColors;
                                barChart.data.datasets[0].pointBorderColor = pointColors;
                                barChart.update();

                            } else if (option.innerText == 'Yearly') {
                                <?php
                                $sql = "SELECT
                                EXTRACT(MONTH FROM timestamp) AS month,
                                SUM(meter_reading) AS total_meter_reading
                            FROM train
                            WHERE timestamp >= '2016-01-01 00:00:00'
                                AND timestamp <= '2016-12-31 23:00:00'
                                AND building_id = 181
                            GROUP BY month
                            ORDER BY month";
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
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $meter_reading[] = $row["total_meter_reading"];
                                        }
                                    }
                                }
                                ?>

                                meter_reading = <?php echo json_encode($meter_reading); ?>;
                                timestamp = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                                lineChart.data.datasets[0].data = meter_reading;
                                lineChart.data.labels = timestamp;
                                lineChart.update();

                                barChart.data.datasets[0].data = meter_reading;
                                barChart.data.labels = timestamp;
                                barChart.update();

                            }
                            selected.classList.remove('select-clicked');
                            caret.classList.remove('caret-rotate');
                            intervalMenu.classList.remove('intervalMenu-open');

                            options.forEach(option => {
                                option.classList.remove('active');
                            });
                            option.classList.add('active');

                        });
                    });
                });

                function addData(chart, label, newData) {
                    chart.data.labels.push(label);
                    chart.data.datasets.forEach((dataset) => {
                        dataset.data.push(newData);
                    });
                    chart.update();
                }

                function removeData(chart) {
                    chart.data.labels.pop();
                    chart.data.datasets.forEach((dataset) => {
                        dataset.data.pop();
                    });
                    chart.update();
                }
            </script>

        </div>

        <section>

</body>

</html>