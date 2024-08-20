<?php
require ('includes/essentials.php');
require ('includes/dbConfig.php');

adminLogin();

if (isset($_POST['but_search'])) {
    $fromDate = $_POST['fromDate'];
    $endDate = $_POST['endDate'];

    $final_from = date('Y-m-d', strtotime($fromDate));
    $final_to = date('Y-m-d', strtotime($endDate));

    $add_qry = "WHERE ao.created_at between '" . $final_from . "' AND '" . $final_to . "' ";
} else {
    $add_qry = "";
}

// Fetch data for the bar chart
$chart_sql = "SELECT ad.service_name, COUNT(*) as appointment_count 
              FROM `appointment_order` ao 
              INNER JOIN `appointment_details` ad ON ao.id = ad.appointment_id 
              $add_qry 
              GROUP BY ad.service_name";
$chart_result = mysqli_query($con, $chart_sql);

$services = [];
$appointment_counts = [];

while ($row = mysqli_fetch_assoc($chart_result)) {
    $services[] = $row['service_name'];
    $appointment_counts[] = $row['appointment_count'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include existing head content -->
    <title>DentalPal - Appointment Records</title>
    <?php require ('includes/links.php'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <style>
        .custom-alert {
            position: fixed;
            top: 80px;
            right: 25px;
        }
        #dashboard-menu {
            position: fixed;
            height: 100%;
            z-index: 11;
        }
        @media screen and (max-width: 991px) {
            #dashboard-menu {
                height: auto;
                width: 100%;
            }
            #main-content {
                margin-top: 60px;
            }
        }
        #chart-container {
            width: 80%;
            height: 400px;
            margin: 50px auto;
        }
    </style>
</head>
<body style="background-color: rgb(248,247,250);">
    <?php require ('includes/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        
                        <!-- Bar chart -->
                        <div class="row">
                             <div id="chart-container" class="col-12 mx-0 my-0 mb-5">
                                     <h3>Appointments Per Service</h3>
                                     <canvas id="serviceChart"></canvas>
                             </div>
                         </div>
                        <div class="text-center">
                            <!-- Search filter -->
                            <form method='post' action='' style="font-size: 18px;">
                                From: <input style="font-size: 18px;" type='date' class='dateFilter' name='fromDate'
                                    value='<?php if (isset($_POST['fromDate'])) echo $_POST['fromDate']; ?>' required>
                                To: <input style="font-size: 18px;" type='date' class='dateFilter' name='endDate'
                                    value='<?php if (isset($_POST['endDate'])) echo $_POST['endDate']; ?>' required>
                                <input type='submit' name='but_search' value='Generate'
                                    style="background-color: #595959; border-color: white; padding: 3px; width: 100px; color: white; border-radius: 5px; font-size: 18px;">
                            </form>
                        </div>
                        

                        <?php
                            // Attempt select query execution
                        
                        $sql = "SELECT ao.*, ad.* FROM `appointment_order` ao INNER JOIN `appointment_details` ad ON ao.id = ad.appointment_id $add_qry";

                        $count_sql = "SELECT COUNT(*) as count FROM `appointment_order` ao INNER JOIN `appointment_details` ad ON ao.id = ad.appointment_id $add_qry";
                        $count_result = mysqli_query($con, $count_sql);
                        $count_row = mysqli_fetch_assoc($count_result);
                        $total_appointments = $count_row['count'];

                        $total_amount_sql = "SELECT SUM(ad.price) AS total_amount FROM `appointment_details` ad INNER JOIN `appointment_details` ao ON ao.id = ad.appointment_id $add_qry";
                        $total_amount_result = mysqli_query($con, $total_amount_sql);
                        $total_amount_row = mysqli_fetch_assoc($total_amount_result);
                        $total_amount = $total_amount_row['total_amount'];
                        $i = 1;
                        if ($result = mysqli_query($con, $sql)) {
                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table table-hover' id='myTable'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>No.</th>";
                                echo "<th>Patient ID</th>";
                                echo "<th>Service ID</th>";
                                echo "<th>Date</th>";
                                echo "<th>Time</th>";
                                echo "<th>Appointment Status</th>";
                                echo "<th>Amount</th>";
                                echo "<th>Refund</th>";
                                echo "<th>Date</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result)) {
                                    if ($row['refund'] == 1) {
                                        $refund = 'Refunded';
                                    } else {
                                        $refund = 'No refund initiated';
                                    }
                                    echo "<tr>";
                                    echo "<td>" . $i . "</td>";
                                    echo "<td>" . $row['patient_name'] . "</td>";
                                    echo "<td>" . $row['service_name'] . "</td>";
                                    echo "<td>" . $row['date'] . "</td>";
                                    echo "<td>" . $row['time'] . "</td>";
                                    echo "<td>" . $row['appointment_status'] . "</td>";
                                    echo "<td>" . $row['trans_amt'] . "</td>";
                                    echo "<td>" . $refund . "</td>";
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    // echo "<td>" . $row['datentime'] . "</td>";
                                    echo "</tr>";
                                    $i++;
                                }
                                echo "</tbody>";
                                echo "</table>";

                                // Free result set
                                mysqli_free_result($result);
                            } else {
                                echo "<p class='lead'><em>No records were found.</em></p>";
                            }
                        } else {
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
                        }

                        // Close connection
                        mysqli_close($con);
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require ('includes/scripts.php'); ?>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function () {
            // DataTables initialization code...

            // Bar chart initialization
            var ctx = document.getElementById('serviceChart').getContext('2d');
            var serviceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($services); ?>,
                    datasets: [{
                        label: 'Number of Appointments',
                        data: <?php echo json_encode($appointment_counts); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    <script src="scripts/dashboard.js"></script>
</body>
</html>
