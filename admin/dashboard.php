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
    <title>ADMIN PANEL - DASHBOARD</title>
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
<body class="bg-white">
    <?php 
        require('includes/header.php');

        $is_shutdown = mysqli_fetch_assoc(mysqli_query($con,"SELECT `shutdown` FROM `settings`"));

        $current_appointment = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(CASE WHEN appointment_status='Pending' AND rate_review=0 THEN 1 END) AS `new_appointments`,COUNT(CASE WHEN appointment_status='Cancelled' AND refund = 0 THEN 1 END) AS `refund_appointments` FROM `appointment_order`"));

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
                        <a href="new_bookings.php" class="text-decoration-none">
                            <div class="card text-center text-success p-3">
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
                        <a href="refund_bookings.php" class="text-decoration-none">
                            <div class="card text-center text-warning p-3">
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
                        <a href="guest_queries.php" class="text-decoration-none">
                            <div class="card text-center text-info p-3">
                                <h6>Guest Quiries</h6>
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
                            <div class="card text-center text-info p-3">
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
                        <div class="card text-center text-primary p-3">
                            <h6>Total Appointments</h6>
                            <h1 class="mt-2 mb-0" id="total_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="total_bookings_amt">₱0</h4>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Active Appointments</h6>
                            <h1 class="mt-2 mb-0" id="active_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="active_bookings_amt">₱0</h4>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Cancelled Appointments</h6>
                            <h1 class="mt-2 mb-0" id="cancelled_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="cancelled_bookings_amt">₱0</h4>
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
                        <div class="card text-center text-success p-3">
                            <h6>New Registration</h6>
                            <h1 class="mt-2 mb-0" id="total_new_reg">0</h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Quiries</h6>
                            <h1 class="mt-2 mb-0" id="total_queries">0</h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Reviews</h6>
                            <h1 class="mt-2 mb-0" id="total_reviews">0</h1>
                        </div>
                    </div>

                </div>

                <!-- users -->
                <h5 class="mb-4">PATIENTS</h5>
                <div class="row mb-3">

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-info p-3">
                            <h6>TOTAL PATIENTS</h6>
                            <h1 class="mt-2 mb-0">
                            <?php
                                    echo $current_patients['total'];
                                ?>
                            </h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>ACTIVE PATIENTS</h6>
                            <h1 class="mt-2 mb-0">
                                <?php
                                    echo $current_patients['active'];
                                ?>
                            </h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-warning p-3">
                            <h6>INACTIVE PATIENTS</h6>
                            <h1 class="mt-2 mb-0">
                            <?php
                                    echo $current_patients['inactive'];
                                ?>
                            </h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
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
</body>
</html>