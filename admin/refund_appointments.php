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
    <title>DentalPal - Refund Appointments</title>
    <?php require('includes/links.php');?>
    <style>
        .custom-alert{
            position: fixed;
            top: 80px;
            right: 25px;
            z-index: 99999;
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
                
            <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                            
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="m-0">REFUND APPOINTMENTS</h4>
                                    <input type="text" oninput="get_appointments(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type to SEARCH">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="text-white" style="background-color: rgb(100,20,22);">
                                            <th scope="col">#</th>
                                            <th scope="col">Patient Details</th>
                                            <th scope="col">Service Details</th>
                                            <th scope="col">Appointment Details</th>
                                            <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="appointmentData">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <?php require('includes/scripts.php');?>
    <script src="scripts/refund_appointments.js"></script>
</body>
</html>