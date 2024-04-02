<?php
    require('includes/essentials.php');
    require('includes/dbConfig.php');

    adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PANEL - SETTINGS</title>
    <?php require('includes/links.php');?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <style>
        .custom-alert{
            position: fixed;
            top: 80px;
            right: 25px;
        }
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
    ?>

<div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                
            <h1 class="h2">APPOINTMENT RECORDS</h1>

            <h4 class="mb-4">PRINT RECORDS</h4>
                <div class="card-body table-responsive-lg mt-4 mb-4 shadow" style="overflow-x: scroll;">
                    <?php
                        // Attempt select query execution

                        $sql = "SELECT * FROM appointment_details";
                        $i = 1;
                        if($result = mysqli_query($con, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                echo "<table class='table table-bordered table-striped' id='myTable'>";
                                    echo "<thead>";
                                        echo "<tr>";
                                            echo "<th>No.</th>";
                                            echo "<th>Patient Name</th>";
                                            echo "<th>Gender</th>";
                                            echo "<th>Address</th>";
                                            echo "<th>Contact Number</th>";
                                            echo "<th>Email</th>";
                                            echo "<th>Service</th>";
                                            echo "<th>Date of Appointment</th>";
                                            echo "<th>Status</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<tr>";
                                            echo "<td>" . $i . "</td>";
                                            echo "<td>" . $row['patient_name'] . "</td>";
                                            echo "<td>" . $row['phone_num'] . "</td>";
                                            echo "<td>" . $row['patient_email'] . "</td>";
                                            echo "<td>" . $row['service_name'] . "</td>";
                                            echo "<td>" . $row['address'] . "</td>";
                                            echo "<td>" . $row['created_at'] . "</td>";
                                            echo "<td>" . $row['total_pay'] . "</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                                
                                // Free result set
                                mysqli_free_result($result);
                            } else{
                                echo "<p class='lead'><em>No records were found.</em></p>";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
                        }

                        // Close connection
                        mysqli_close($con);
                    ?>
            </div>
        </div>
    </div>


    <?php require('includes/scripts.php');?>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'print'
                ]
            } );
        } );
    </script>
    <script src="scripts/dashboard.js"></script>
</body>
</html>