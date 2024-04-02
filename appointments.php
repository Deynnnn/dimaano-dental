<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/custom.css">
    <?php require('includes/links.php');?>
    <title>DentalPal - Appointments</title>
    <?php
        if(isset($_GET['page-nr'])){
            $id = $_GET['page-nr'];
        }else{
            $id  =1;
        }
    ?>
</head>
<body id="<?php echo $id;?>">
    <style>
        .site-title{
            color: rgb(165,16,18);
        }
        .custom-alert{
            position: fixed;
            top: 25px;
            right: 25px;
        }
        a.actived{
            background-color: #0D6EFD;
            color: #fff;
            border: thin solid #0D6EFD;
        }
    </style>
    <div>
        <?php 
        require('includes/navbar.php') ;
        if(!(isset($_SESSION['login']) || $_SESSION['login'] == true)){
            redirect('index.php');
        }
        ?>
    </div>

    <div class="container">
        <div class="row"> 
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">Appointments</h2>

                <div style="font-size: 14px;">
                    <a href="index.php" class="text-decoration-none text-secondary">
                        Home >
                    </a>
                    <a href="#" class="text-decoration-none text-secondary">
                        Appointments
                    </a><br>
                </div>
                <!-- <h4 class="shadow-sm"><span class="badge bg-light text-secondary text-wrap lh-base d-block">DON'T FORGET TO RATE AND REVIEW OUR SERVICES, WE LOVE TO HEAR IT FROM YOU BECAUSE YOU MATTER TO US!</span></h4> -->
            </div>
            <div class="col-12 px-4 mb-2">
                <h1>New Appointments</h1>
            </div>
            <?php
                // pagination not working properly
                $start = 0;
                $limit = 3;

                $records = $con->query("SELECT * FROM `appointment_order` WHERE `patient_id` = $_SESSION[uId] AND `appointment_status`='Pending'");

                $num_of_rows = $records->num_rows;
                $pages = ceil($num_of_rows / $limit);

                if(isset($_GET['page-nr'])){
                    $page = $_GET['page-nr'] - 1;
                    $start = $page * $limit;
                }

                $query = "SELECT ao.*, ad.* FROM `appointment_order` ao INNER JOIN `appointment_details` ad ON ao.id = ad.appointment_id WHERE ao.appointment_status='Pending' AND ao.patient_id = ? ORDER BY ao.id DESC LIMIT $start, $limit";
                $res = select($query, [$_SESSION['uId']], 'i');
                // $pagination = $con->query('SELECT * FROM `appointment_order` WHERE `appointment_status` = "Pending" ');
                


                

                while($data = mysqli_fetch_assoc($res)){
                    $created_at = date('d-m-Y', strtotime($data['created_at']));
                    $date = date('m-d-Y', strtotime($data['date']));
                    $time = date('h:m:s a', strtotime($data['time']));

                    $price = $data['total_pay'];
                    $formatedPrice = number_format($price,2,'.',',');

                    echo<<<appointments
                        <div class='col-md-4 px-4 mb-4'>
                            <div class='p-3 rounded shadow-sm' style="background-color: rgba(255, 99, 132, 0.2);border: 2px solid rgb(255, 99, 132);">
                                <p class='badge bg-dark'>
                                    <b>Order ID: </b>$data[order_id]
                                </p>
                                <h5 class='fw-bold'>$data[service_name]</h5>
                                <p>₱$formatedPrice</p>
                                <p class='badge text-dark' style="background-color: rgba(255, 99, 132, 0.4);">
                                    <b>Prefered Date: </b>$date
                                </p>
                                <p class='badge text-dark' style="background-color: rgba(255, 99, 132, 0.4);">
                                    <b>Prefered Time: </b>$time
                                </p>
                                <p>
                                    <b>Amount: </b>₱$formatedPrice<br>
                                    <b>Date: </b> $created_at
                                </p>
                                <div class="container">
                                    <div class="row">
                                            <p class='badge bg-warning text-dark fs-6'>$data[appointment_status]</p>
                                            <button onclick='cancel_appointment($data[id], "$data[order_id]")' type='button' class='btn btn-outline-danger btn-sm shadow-none'>
                                                Cancel Appointment
                                            </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    appointments;
                }



            ?>
            <div class="">
                <div class="page-info ms-2 fw-light">
                    <?php
                        if(!isset($_GET['page-nr'])){
                            $page = 1;
                        }else{
                            $page = $_GET['page-nr'];
                        }
                    ?>
                    Showing <?php echo $page?> of <?php echo $pages?> pages
                </div>
                <div class="pagination">
                    <a href="?page-nr=1" class="text-decoration-none btn btn-outline-primary mx-1">First</a>
                    <?php
                        if(isset($_GET['page-nr']) && $_GET['page-nr'] > 1){
                    ?>
                        <a href="?page-nr=<?php echo $_GET['page-nr'] - 1?>"  class="text-decoration-none btn btn-outline-primary mx-1">Previous</a>
                    <?php
                        }else{
                            ?>
                            <a  class="text-decoration-none btn btn-outline-primary mx-2 disabled">Previous</a>
                    <?php
                        }
                    ?>
        
                    <!-- <div class="page-numbers">
                        <?php
                            for($counter = 1; $counter <= $pages; $counter++){
                        ?>
                            <a href="?page-nr=<?php echo $counter?>" class="text-decoration-none btn btn-outline-primary mx-1"><?php echo $counter?></a>
                        <?php
                        }
                        ?>
                    </div> -->
                    <?php
                        if(!isset($_GET['page-nr'])){
                    ?>
                        <a href="?page-nr=2" class="text-decoration-none btn btn-outline-primary mx-1">Next</a>
        
                    <?php
                        }else{
                            if($_GET['page-nr'] >= $pages){
                                ?>
                                <a class="text-decoration-none btn btn-outline-primary mx-1 disabled">Next</a>
                    <?php
                            }else{
                    ?>
                            <a href="?page-nr=<?php echo $_GET['page-nr'] + 1 ?>" class="text-decoration-none btn btn-outline-primary mx-1">Next</a>
                        <?php    
                        }
                    ?>
                    <?php
                        }
                    ?>
                    <a href="?page-nr=<?php echo $pages ?>" class="text-decoration-none btn btn-outline-primary mx-1">Last</a>
                </div>
            </div>
        </div>
    </div>
    

    <?php require('includes/footer.php');?>
    <script>

        let links =document.querySelectorAll('.page-numbers > a');
        let bodyId =parseInt(document.body.id) - 1;
        links[bodyId].classList.add("actived");

        function cancel_appointment(id, order_id){
            if(confirm('Are you SURE to CANCEL appointment? Only 80% of your payment will be REFUNDED!')){
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/appointments.php", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function(){
                    if(this.responseText==1){
                        window.location.href="appointments.php?cancel_status=true";
                        alert('success', 'Appointment Cancelled.');
                    }else if(this.responseText == 'mail_failed'){
                        alert('error', 'Email failed to sent.');
                    }
                    else{
                        alert('error', 'Cancellation Failed')
                    }
                }
        
                xhr.send('cancel_appointment&id='+id+'&order_id='+order_id);
            }
        }

        // function check_out(b_id, r_id){
        //     if(confirm('Are you about to check out, Confirm to continue.')){
        //         let xhr = new XMLHttpRequest();
        //         xhr.open("POST", "ajax/cancel_booking.php", true);
        //         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        //         xhr.onload = function(){
        //             if(this.responseText==1){
        //                 window.location.href="bookings.php?checkout_status=true";
        //                 alert('success', 'Checkout Successful')
        //             }else{
        //                 alert('error', 'Checkout Failed')
        //             }
        //         }
        
        //         xhr.send('check_out&b_id=' + b_id + '&r_id=' + r_id);
        //     }
        // }

        // let review_form = document.getElementById('review-form');
        // function review_room(bid, rid){
        //     review_form.elements['booking_id'].value = bid;
        //     review_form.elements['room_id'].value = rid;
        // }

        // review_form.addEventListener('submit', function(e){
        //     e.preventDefault();

        //     let data = new FormData();
        //     data.append('review_form', '');
        //     data.append('rating',review_form.elements['rating'].value);
        //     data.append('review',review_form.elements['review'].value);
        //     data.append('booking_id',review_form.elements['booking_id'].value);
        //     data.append('room_id',review_form.elements['room_id'].value);

            

        //     let xhr = new XMLHttpRequest();
        //     xhr.open("POST", "ajax/review_room.php", true);

        //     xhr.onload = function(){
        //         if(this.responseText == 1){
        //             window.location.href = 'bookings.php?review_status=true'
        //         }else{
        //             var myModal = document.getElementById('rate_reviewModal');
        //             var modal = bootstrap.Modal.getInstance(myModal);
        //             modal.hide();
        //             alert('success', "Rating & Review Failed");
        //         }
                
        //     }
        //     xhr.send(data);
        // });
    </script>
</body>
</html>