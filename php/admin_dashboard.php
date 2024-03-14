<?php
$errors = array();
session_start();
include 'DB/DataBase.php';
include 'side-bar.php';

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
        <div class="dropdown">
            <div class="select">
                <span class="selected">Daily</span>
                <div class="caret"></div>
            </div>
            <ul class="intervalMenu">
                <li class="active">Daily</li>
                <li>Weekly</li>
                <li>Monthly</li>
                <li>Yearly</li>
            </ul>
        </div>

        <script>
            
        </script>
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
                        label: 'Meter Reading',
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

                var lineChart = new Chart(
                    document.getElementById('lineChart'),
                    config
                );

                var data = {
                    labels: timestamp,
                    datasets: [{
                        label: 'Meter Reading',
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

                var barChart = new Chart(
                    document.getElementById('barChart'),
                    config
                );

                const dropdowns = document.querySelectorAll('.dropdown');

            dropdowns.forEach(dropdown =>{
                const select = dropdown.querySelector('.select');
                const caret = dropdown.querySelector('.caret');
                const intervalMenu = dropdown.querySelector('.intervalMenu');
                const options = dropdown.querySelectorAll('.intervalMenu li');
                const selected = dropdown.querySelector('.selected');

                select.addEventListener('click', () =>{
                    select.classList.toggle('select-clicked');
                    caret.classList.toggle('caret-rotate');
                    intervalMenu.classList.toggle('intervalMenu-open');

                });
                options.forEach(option=>{
                    option.addEventListener('click', ()=>{
                        selected.innerText = option.innerText;
                        if(option.innerText == 'Daily'){

                        }
                        else if(option.innerText == 'Weekly'){

                        }
                        else if(option.innerText == 'Monthly'){

                        }
                        else if(option.innerText == 'Yearly'){

                        }
                        selected.classList.remove('select-clicked');
                        caret.classList.remove('caret-rotate');
                        intervalMenu.classList.remove('intervalMenu-open');

                        options.forEach(option=>{
                            option.classList.remove('active');
                        });
                        option.classList.add('active');

                    });
                });
            });
            </script>

        </div>

        <section>

</body>

</html>