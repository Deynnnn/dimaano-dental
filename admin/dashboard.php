<?php
    require('includes/essentials.php');
    require('includes/dbConfig.php');

    adminLogin();

    $daily_data = [];
$weekly_data = [];
$monthly_data = [];

$daily_query = "SELECT DATE(created_at) as date, COUNT(*) as count FROM `appointment_order` ao GROUP BY DATE(created_at)";
$weekly_query = "SELECT YEARWEEK(created_at, 1) as week, COUNT(*) as count FROM `appointment_order` ao GROUP BY YEARWEEK(created_at, 1)";
$monthly_query = "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count FROM `appointment_order` ao GROUP BY DATE_FORMAT(created_at, '%Y-%m')";

$daily_result = mysqli_query($con, $daily_query);
$weekly_result = mysqli_query($con, $weekly_query);
$monthly_result = mysqli_query($con, $monthly_query);

while ($row = mysqli_fetch_assoc($daily_result)) {
    $daily_data[$row['date']] = $row['count'];
}
while ($row = mysqli_fetch_assoc($weekly_result)) {
    $weekly_data[$row['week']] = $row['count'];
}
while ($row = mysqli_fetch_assoc($monthly_result)) {
    $monthly_data[$row['month']] = $row['count'];
}

// Convert PHP arrays to JSON for JavaScript
$daily_data_json = json_encode($daily_data);
$weekly_data_json = json_encode($weekly_data);
$monthly_data_json = json_encode($monthly_data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DentalPal - Dashboard</title>
    <?php require('includes/links.php');?>
    <style>
        #dashboard-menu{
            position: fixed;
            height: 100%;
            z-index: 11;
        }

        @media screen and (max-width: 991px){
            #dashboard-menu{
                height: auto;
                width: 100%;
            }
            #main-content{
                margin-top: 60px;
            }
        }
    </style>
</head>
<body style="background-color: rgb(248,247,250);">
    <?php 
        require('includes/header.php');

        $is_shutdown = mysqli_fetch_assoc(mysqli_query($con,"SELECT `shutdown` FROM `settings`"));

        $current_appointment = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(CASE WHEN appointment_status='New' AND rate_review=0 THEN 1 END) AS `new_appointments`,COUNT(CASE WHEN appointment_status='Cancelled' AND refund = 1 THEN 1 END) AS `refund_appointments` FROM `appointment_order`"));

        $unread_quiries = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(sr_no) AS `count` FROM `patient_queries` WHERE `seen`=0"));
        $unread_reviews = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(id) AS `count` FROM `rating_review` WHERE `seen`=0"));

        $current_patients = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(id) as `total`, COUNT(CASE WHEN `status` = 1 THEN 1 END) AS `active`,COUNT(CASE WHEN `status` = 0 THEN 1 END) AS `inactive`,COUNT(CASE WHEN `is_verified` = 0 THEN 1 END) AS `unverified` FROM `patients`"));
    
    ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <!-- dashborad -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>DASHBOARD</h3>
                    <?php
                        if($is_shutdown['shutdown']){
                            echo<<<data
                                <h6 class="badge bg-danger py-2 px-3 rounded">Shutdown Mode is Active</h6>
                            data;
                        }
                    ?>
                </div>

                <div class="row mb-4">

                    <div class="col-md-3 mb-4">
                        <a href="new_appointments.php" class="text-decoration-none">
                            <div class="card text-center border-0 shadow text-success p-3">
                                <h6>New Appointments</h6>
                                <h1 class="mt-2 mb-0">
                                    <?php
                                        echo $current_appointment['new_appointments']
                                    ?>
                                </h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 mb-4">
                        <a href="refund_appointments.php" class="text-decoration-none">
                            <div class="card text-center border-0 shadow text-warning p-3">
                                <h6>Refund Appointments</h6>
                                <h1 class="mt-2 mb-0">
                                <?php
                                        echo $current_appointment['refund_appointments']
                                    ?>
                                </h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 mb-4">
                        <a href="patient_queries.php" class="text-decoration-none">
                            <div class="card text-center border-0 shadow text-info p-3">
                                <h6>Patient Quiries</h6>
                                <h1 class="mt-2 mb-0">
                                <?php
                                    echo $unread_quiries['count']
                                ?>
                                </h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 mb-4">
                        <a href="rate_review.php" class="text-decoration-none">
                            <div class="card text-center border-0 shadow text-info p-3">
                                <h6>Rating & Review</h6>
                                <h1 class="mt-2 mb-0">
                                <?php
                                    echo $unread_reviews['count']
                                ?>
                                </h1>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- booking analytics -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>APPOINTMENT ANALYTICS</h5>
                    <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">
                        <option value="1">Past 30 Days</option>
                        <option value="2">Past 90 Days</option>
                        <option value="3">Past 1 Year </option>
                        <option value="4">All Time </option>
                    </select>
                </div>
                <div class="row mb-3">

                    <div class="col-md-3 mb-4">
                        <div class="card text-center border-0 shadow text-primary p-3">
                            <h6>Total Appointments</h6>
                            <h1 class="mt-2 mb-0" id="total_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="total_bookings_amt">₱0</h4>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center border-0 shadow text-success p-3">
                            <h6>Active Appointments</h6>
                            <h1 class="mt-2 mb-0" id="active_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="active_bookings_amt">₱0</h4>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center border-0 shadow text-secondary p-3">
                            <h6>Past Appointments</h6>
                            <h1 class="mt-2 mb-0" id="past_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="past_bookings_amt">₱0</h4>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center border-0 shadow text-danger p-3">
                            <h6>Cancelled Appointments</h6>
                            <h1 class="mt-2 mb-0" id="cancelled_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="cancelled_bookings_amt">₱0</h4>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-4">
                            <h4>Daily Appointments</h4>
                            <canvas id="dailyChart"></canvas>
                        </div>
                        <div class="col-4">
                            <h4>Weekly Appointments</h4>
                            <canvas id="weeklyChart"></canvas>
                        </div>
                        <div class="col-4">
                            <h4>Monthly Appointments</h4>
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>

                </div>

                <!-- user, quiries, reviews analytics -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>PATIENTS, QUIRIES, REVIEWS ANALYTICS</h5>
                    <select class="form-select shadow-none bg-light w-auto" onchange="user_analytics(this.value)">
                        <option value="1">Past 30 Days</option>
                        <option value="2">Past 90 Days</option>
                        <option value="3">Past 1 Year </option>
                        <option value="4">All Time </option>
                    </select>
                </div>
                <div class="row mb-3">

                    <div class="col-md-3 mb-4">
                        <div class="card text-center border-0 shadow text-success p-3">
                            <h6>New Registration</h6>
                            <h1 class="mt-2 mb-0" id="total_new_reg">0</h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center border-0 shadow text-primary p-3">
                            <h6>Quiries</h6>
                            <h1 class="mt-2 mb-0" id="total_queries">0</h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center border-0 shadow text-primary p-3">
                            <h6>Reviews</h6>
                            <h1 class="mt-2 mb-0" id="total_reviews">0</h1>
                        </div>
                    </div>

                </div>

                <!-- users -->
                <h5 class="mb-4">PATIENTS</h5>
                <div class="row mb-3">

                    <div class="col-md-3 mb-4">
                        <div class="card text-center border-0 shadow text-info p-3">
                            <h6>TOTAL PATIENTS</h6>
                            <h1 class="mt-2 mb-0">
                            <?php
                                    echo $current_patients['total'];
                                ?>
                            </h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center border-0 shadow text-success p-3">
                            <h6>ACTIVE PATIENTS</h6>
                            <h1 class="mt-2 mb-0">
                                <?php
                                    echo $current_patients['active'];
                                ?>
                            </h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center border-0 shadow text-warning p-3">
                            <h6>INACTIVE PATIENTS</h6>
                            <h1 class="mt-2 mb-0">
                            <?php
                                    echo $current_patients['inactive'];
                                ?>
                            </h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center border-0 shadow text-danger p-3">
                            <h6>UNVERIFIED PATIENTS</h6>
                            <h1 class="mt-2 mb-0">
                            <?php
                                echo $current_patients['unverified'];
                            ?>
                            </h1>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <?php require('includes/scripts.php');?>
    <script src="scripts/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Parse JSON data from PHP
    const dailyData = JSON.parse('<?php echo $daily_data_json; ?>');
    const weeklyData = JSON.parse('<?php echo $weekly_data_json; ?>');
    const monthlyData = JSON.parse('<?php echo $monthly_data_json; ?>');

    // Prepare data for daily chart
    const dailyLabels = Object.keys(dailyData);
    const dailyCounts = Object.values(dailyData);

    // Prepare data for weekly chart
    const weeklyLabels = Object.keys(weeklyData);
    const weeklyCounts = Object.values(weeklyData);

    // Prepare data for monthly chart
    const monthlyLabels = Object.keys(monthlyData);
    const monthlyCounts = Object.values(monthlyData);

    // Generate Daily Utilization Chart
    new Chart(document.getElementById('dailyChart'), {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Daily Appointments',
                data: dailyCounts,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Number of Appointments'
                    }
                }
            }
        }
    });

    // Generate Weekly Utilization Chart
    new Chart(document.getElementById('weeklyChart'), {
        type: 'bar',
        data: {
            labels: weeklyLabels,
            datasets: [{
                label: 'Weekly Appointments',
                data: weeklyCounts,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Week'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Number of Appointments'
                    }
                }
            }
        }
    });

    // Generate Monthly Utilization Chart
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Monthly Appointments',
                data: monthlyCounts,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
        }
    });
</script>

</body>
</html>