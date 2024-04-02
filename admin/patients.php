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

            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="m-0">PATIENTS</h4>
                        <input type="text" oninput="search_user(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type to SEARCH">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-center" style="min-width: 1300px;">
                            <thead>
                                <tr class="text-white" style="background-color: rgb(100,20,22);">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Contact Number</th>
                                <th scope="col">Location</th>
                                <th scope="col">Birthday</th>
                                <th scope="col">Verified</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                                <th scope="col">History</th>
                                </tr>
                            </thead>
                            <tbody id="users-data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php require('includes/scripts.php');?>
    <script src="scripts/users.js"></script>
</body>
</html>