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
                    <a href="appointments.php?page-nr=1" class="text-decoration-none text-secondary">
                        New Appointments |
                    </a>
                    <a href="rescheduled_appointments.php?page-nr=1" class="text-decoration-none text-secondary">
                        Rescheduled Appointments |
                    </a>
                    <a href="appointments_history.php?page-nr=1" class="text-decoration-none text-secondary">
                        Appointments History |
                    </a>
                </div>
                <!-- <h4 class="shadow-sm"><span class="badge bg-light text-secondary text-wrap lh-base d-block">DON'T FORGET TO RATE AND REVIEW OUR SERVICES, WE LOVE TO HEAR IT FROM YOU BECAUSE YOU MATTER TO US!</span></h4> -->
            </div>
            <div class="col-12 px-4 mb-2">
                <h1>Appointments History</h1>
            </div>
            <?php
                // pagination not working properly
                $start = 0;
                $limit = 3;

                $records = $con->query("SELECT * FROM `appointment_order` WHERE `appointment_status`='Accepted' AND `patient_id` = $_SESSION[uId]");

                $num_of_rows = $records->num_rows;
                $pages = ceil($num_of_rows / $limit);

                if(isset($_GET['page-nr'])){
                    $page = $_GET['page-nr'] - 1;
                    $start = $page * $limit;
                }

                $query = "SELECT ao.*, ad.* FROM `appointment_order` ao INNER JOIN `appointment_details` ad ON ao.id = ad.appointment_id WHERE ao.appointment_status = 'Accepted' AND ao.patient_id = ? ORDER BY ao.id DESC LIMIT $start, $limit";
                $res = select($query, [$_SESSION['uId']], 'i');
                // $pagination = $con->query('SELECT * FROM `appointment_order` WHERE `appointment_status` = "Pending" ');
                
                if(mysqli_num_rows($res) == 0){
                    echo "<h5 class='fw-bold'>Welcome Back! Your appointment are still pending.</h5>";
                }
                

                while($data = mysqli_fetch_assoc($res)){
                    $created_at = date('d-m-Y', strtotime($data['created_at']));
                    $date = date('m-d-Y', strtotime($data['date']));
                    $time = date('h:m:s a', strtotime($data['time']));

                    $btn = "";

                    $price = $data['total_pay'];
                    $formatedPrice = number_format($price,2,'.',',');

                    if($data['rate_review'] == 0){
                        $btn .= "<button type='button' onclick='review_appointment($data[id], $data[service_id])' data-bs-toggle='modal' data-bs-target='#rate_reviewModal' class='btn btn-success btn-sm shadow-none'>
                        Rate and Review
                        </button>";
                    }else{
                        $btn;
                    }


                    echo<<<appointments
                        <div class='col-lg-4 col-md-6 col-sm-12 px-4 mb-4'>
                            <div class='p-3 rounded shadow-sm' style="background-color: rgb(78,186,22, 0.2);border: 2px solid rgb(78,186,22);">
                                <p class='badge bg-dark'>
                                    <b>Order ID: </b>$data[order_id]
                                </p>
                                <h5 class='fw-bold'>$data[service_name]</h5>
                                <p>₱$formatedPrice</p>
                                <p class='badge text-dark' style="background-color: rgb(78,186,22, 0.6);">
                                    <b>Prefered Date: </b>$date
                                </p>
                                <p class='badge text-dark' style="background-color: rgb(78,186,22, 0.6);">
                                    <b>Prefered Time: </b>$time
                                </p>
                                <p>
                                    <b>Amount: </b>₱$formatedPrice<br>
                                    <b>Date: </b> $created_at
                                </p>
                                <div class="container">
                                    <div class="row">
                                            $btn
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
    
    <div class="modal fade" id="rate_reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="reviewForm">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-chat-square-heart-fill fs-3 me-2"></i></i>Rate & Review
                        </h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <span class="badge bg-light text-success mb-3 text-wrap lh-base">Rate services you acquire on our clinic we are honored to hear it from you!</span>
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select class="form-select shadow-none" aria-label="Default select example" name="rating">
                                <option value="5">Excellent</option>
                                <option value="4">Good</option>
                                <option value="3">Fair</option>
                                <option value="2">Poor</option>
                                <option value="1">Bad</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Review</label>
                            <textarea name="review" id="" rows="3" class="form-control shadow-none" required></textarea>
                        </div>

                        <input type="hidden" name="id">
                        <input type="hidden" name="service_id">

                        <div class="text-end">
                            <button class="btn btn-success text-light shadow-none px-4 mb-2" >SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
        if(isset($_GET['review_status'])){
            alert('success', 'Thankyou for your rating and review!');
        }
    ?>

    <?php require('includes/footer.php');?>
    <script>

        let review_form = document.getElementById('reviewForm');
        function review_appointment(bid, rid){
            review_form.elements['id'].value = bid;
            review_form.elements['service_id'].value = rid;
        }

        review_form.addEventListener('submit', function(e){
            e.preventDefault();

            let data = new FormData();
            data.append('review_form', '');
            data.append('review',review_form.elements['review'].value);
            data.append('rating',review_form.elements['rating'].value);
            data.append('id',review_form.elements['id'].value);
            data.append('service_id',review_form.elements['service_id'].value);

            

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/review_appointment.php", true);

            xhr.onload = function(){
                if(this.responseText == 1){
                    window.location.href = 'appointments_history.php?review_status=true';
                    // alert('error', "Rating & Review Successful");

                }else{
                    var myModal = document.getElementById('rate_reviewModal');
                    var modal = bootstrap.Modal.getInstance(myModal);
                    modal.hide();
                    alert('error', "Rating & Review Failed");
                }
                
            }
            xhr.send(data);
        });

        
        let links =document.querySelectorAll('.page-numbers > a');
        let bodyId =parseInt(document.body.id) - 1;
        links[bodyId].classList.add("actived");
    </script>
</body>
</html>