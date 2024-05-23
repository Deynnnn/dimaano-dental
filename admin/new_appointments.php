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
    <title>DentalPal - New Appointments</title>
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

        .reschedule-btn{
                background-color: rgba(255, 159, 64, 0.2);
                border: 1px solid rgb(255, 159, 64);
            }.reschedule-btn:hover{
                background-color: rgba(255, 159, 64, 0.5);
                border: 1px solid rgb(255, 159, 64);}
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
                                    <h4 class="m-0">NEW APPOINTMENTS</h4>
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

    <div class="modal fade" id="reschedule_date" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reschedule Appointment</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="border-bottom border-3 mb-3 pb-3">
                            <form id="reschedule_form">
                                <h4 class="modal-title">DATE</h4>
                                <label class="form-label fw-bold">FROM</label>
                                <input type="date" name="date" class="form-control shadow-none mb-3" disabled>
                                <label class="form-label fw-bold">TO</label>
                                <input type="date" id="dateInput" class="form-control shadow-none" name="reschedule_date" required>
                                <h4 class="modal-title mt-4">TIME</h4>
                                <label class="form-label fw-bold">FROM</label>
                                <input type="time" name="time" class="form-control shadow-none mb-3" disabled>
                                <label class="form-label fw-bold">TO</label>
                                <input type="time" id="dateInput" min="09:00" max="17:00" class="form-control shadow-none" name="reschedule_time" required>
                                <button class="btn btn-outline-success shadow-none mt-4">Reschedule</button>
                                <input type="hidden" name="id">
                                <input type="hidden" name="patient_email">
                                <input type="hidden" name="order_id">
                                <input type="hidden" name="phone_num">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php require('includes/scripts.php');?>
    <script src="scripts/new_appointments.js"></script>
</body>
</html>