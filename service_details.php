<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('includes/links.php');?>
    <title>DentalPal - Services</title>
</head>
<body>
    <style>
        .site-title{
            color: rgb(165,16,18);
        }
        .custom-alert{
            position: fixed;
            top: 25px;
            right: 25px;
        }
        .custom-bg{
            background-color:  rgb(165,16,18);
            border: 1px solid  rgb(165,16,18);
        }
        .custom-bg:hover{
            background-color:  rgb(165,16,18,.85);
            border: 1px solid  rgb(165,16,18)
        }
    </style>
    <div>
        <?php require('includes/navbar.php');?>
    </div>
    <?php
        if(!isset($_GET['id'])){
            redirect('services.php');
        }

        $data = filteration($_GET);
        $service_res = select("SELECT * FROM `services` where `id`=? and `status`=? and `removed`=?",[$data['id'],1,0],'iii');

        if(mysqli_num_rows($service_res)==0){
            redirect('index.php');  //change to services.php
        }

        $service_data = mysqli_fetch_assoc($service_res);
        $price = $service_data['price'];
        $formatedPrice = number_format($price,2,'.',',');
    ?>
    <div class="container">
        <div class="row"> 

            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold"><?php echo $service_data['name']?></h2>

                <div style="font-size: 14px;">
                    <a href="services.php" class="text-decoration-none text-secondary">
                        <i class="bi bi-arrow-left"></i> GO BACK >
                    </a>
                    <a href="index.php" class="text-decoration-none text-secondary">
                        <i class="bi bi-house-up-fill"></i> HOME
                    </a>
                </div>
            </div>
        <div class="col-lg-7 col-md-12 px-4">
            <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                        $room_img = SERVICES_IMG_PATH."banner.png";
                        $img_q = mysqli_query($con,"SELECT * FROM `service_images` 
                            WHERE `service_id`='$service_data[id]'");
                        if(mysqli_num_rows($img_q)>0){
                            $active_class = 'active';
                            while($img_res = mysqli_fetch_assoc($img_q)){
                                echo"
                                <div class='carousel-item $active_class'>
                                    <img src='".SERVICES_IMG_PATH.$img_res['image']."' class='d-block w-100 rounded' alt=''>
                                </div>
                                ";
                                $active_class='';
                            }
                        }else{
                            echo"
                            <div class='carousel-item active'>
                                <img src='$room_img' class='d-block w-100' alt=''>
                            </div>
                            ";
                        }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <div class="col-lg-5 col-md-12 px-4">
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <?php
                        echo<<<price
                            <h4>₱$formatedPrice</h4>
                        price;

                        $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review` WHERE `service_id`='$service_data[id]' ORDER BY `id` DESC LIMIT 20";
                        $rating_res = mysqli_query($con,$rating_q);
                        $rating_fetch =mysqli_fetch_assoc($rating_res);

                        $rating_data = "";

                        if($rating_fetch['avg_rating']!= NULL){

                            for($i=0;  $i < $rating_fetch['avg_rating']; $i++){
                                $rating_data .= "<i class='bi bi-star-fill text-warning'></i> ";
                            }
                        }else{
                            $rating_data ="<div class='rating mb-4'>
                                                <span class='badge rounded-pill bg-dark'>NO RATINGS YET!</span>
                                            </div>";
                        }


                        echo<<<rating
                        <div class="rating">
                            $rating_data
                        </div>
                        rating;

                        $book_btn = '';

                        if(!$setting_r['shutdown']){
                            $login=0;
                            if(isset($_SESSION['login']) && $_SESSION['login']==true){
                                $login=1;
                            }
                            $book_btn = "<button onclick='checkLoginToBook($login,$service_data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Book Now</button>";
                        }

                        echo<<<book
                            $book_btn
                        book;
                    ?>
                </div>
            </div>
        </div>
            <div class="col-12 px-4">
                <div class="mb-5 mt-3">
                    <h5 style='font-weight:600;'>Description</h5>
                    <p>
                        <?php
                        echo $service_data['description'];
                        ?>
                    </p>
                </div>
                <div class="review-rating">
                    <h5 class='mb-3'>Reviews & Ratings</h5>
                    <?php
                        $review_q ="SELECT rr.*,uc.first_name AS ufname, uc.last_name AS ulname, r.name AS rname FROM `rating_review` rr INNER JOIN `patients` uc ON rr.patient_id = uc.id INNER JOIN `services` r ON rr.service_id = r.id WHERE rr.service_id = '$service_data[id]' ORDER BY `id` DESC LIMIT 15";
                        $review_res = mysqli_query($con,$review_q);
        
                        if(mysqli_num_rows($review_res)==0){
                            echo 'No reviews yet!';
                        }else{
                            while($row = mysqli_fetch_assoc($review_res)){
                                $stars = "<i class='bi bi-star-fill text-warning'></i> ";
                                for($i=1; $i<$row['rating']; $i++){
                                $stars .= "<i class='bi bi-star-fill text-warning'></i> ";
                                }

                                echo<<<reviews
                                <div class='mb-4'>
                                    <div class="d-flex align-items-center mb-2">
                                    <img src="$img_path$row[profile]" loading="lazy" class="rounded-circle" width="35px">
                                    <h6 class="m-0 ms-2">$row[ufname] $row[ulname]</h6>
                                    </div>
                                    <p class='mb-1'>$row[review]</p>
                                    <div>
                                        $stars
                                    </div>
                                </div>
                                reviews;
                            }
                        }
                    ?>
                    
                </div>
            </div>
        </div>

    </div>

    <?php require('includes/footer.php');?>
</body>
</html>