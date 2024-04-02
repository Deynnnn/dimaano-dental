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
                
                <div class="card border-0">
                    <div class="card-body text-center">
                        <h1 class="mb-4">Coming soon 🚀</h1>
                        <img src="../images/cs.png" alt="" class="">
                    </div>
                </div>

            </div>
        </div>
    </div>


    <?php require('includes/scripts.php');?>
    <script src="scripts/dashboard.js"></script>
</body>
</html>