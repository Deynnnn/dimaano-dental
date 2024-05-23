<?php
    require('includes/essentials.php');
    require('includes/dbConfig.php');

    adminLogin();

    if(!isset($_GET['id'])){
        redirect('patients.php');
    }

    $data = filteration($_GET);

    $patient_res = select("SELECT * FROM `patients` where `id`=?",[$data['id']],'i');

    $patient_data = mysqli_fetch_assoc($patient_res);
    // $price = $service_data['price'];
    // $formatedPrice = number_format($price,2,'.',',');
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

    <div class="container" id="main-content">
        <div class="row ms-4">
                
                        <?php 
                            if(!isset($_GET['id'])){
                                redirect('patients.php');
                            }
                        
                            $data = filteration($_GET);
                            $hist_res = select("SELECT * FROM `appointment_order` WHERE `patient_id`=?", [$data['id']], 'i');
                        
                            if(mysqli_num_rows($hist_res)==0){
                                echo "<h1 class='fs-1'>Patient has no appointment history yet.</h1>";
                            }else{
                                echo "<h2 class=''>$patient_data[first_name] $patient_data[last_name] History</h2>";
                            }
                        
                            while($hist_data = mysqli_fetch_assoc($hist_res)){
                                $created_at = date('d-m-Y', strtotime($hist_data['created_at']));
                                $date = date('m-d-Y', strtotime($hist_data['date']));
                                $time = date('h:m:s a', strtotime($hist_data['time']));

                                $price = $hist_data['trans_amt'];
                                $formatedPrice = number_format($price,2,'.',',');

                                $status_bg ='';

                                if($hist_data['appointment_status'] == 'Accepted'){
                                    $status_bg = 'bg-success text-light';
                                }else if($hist_data['appointment_status'] == 'Pending'){
                                    $status_bg = 'bg-warning text-dark';
                                }else if($hist_data['appointment_status'] == 'Cancelled'){
                                    $status_bg = 'bg-secondary text-light';
                                }

                                $service_res = select("SELECT * FROM `appointment_details` WHERE `appointment_id`=?",[$hist_data['id']], 'i');
                                $service_data = mysqli_fetch_assoc($service_res);


                                echo<<<history
                                    <div class='col-lg-4 col-md-6 px-4 mb-4 mt-4'>
                                        <div class='p-3 rounded shadow'>
                                            <h2 class='fw-bold'>$service_data[service_name]</h2>
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <p class='badge bg-light text-dark fs-6 m-0'>
                                                        <b>Order ID: </b>$hist_data[order_id]
                                                    </p>
                                                    <p class="mb-0 fs-5">₱$formatedPrice</p>
                                            </div>

                                            <div class="container">
                                                <div class="row">
                                                        <p class='badge $status_bg fs-6 mb-0'>$hist_data[appointment_status]</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    history;
                            }
                        ?>
        </div>
    </div>

    <?php require('includes/scripts.php');?>
</body>
</html>