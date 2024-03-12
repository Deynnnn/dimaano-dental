<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('includes/links.php');?>
    <title>DentalPal - Services</title>
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
        .custom-bg{
            background-color:  rgb(165,16,18);
            border: 1px solid  rgb(165,16,18);
        }
        .custom-bg:hover{
            background-color:  rgb(165,16,18,.85);
            border: 1px solid  rgb(165,16,18)
        }
        .active{
            border-bottom: 3px solid rgb(164,15,17);
            transition: .15s;
        }
        a.actived{
            background-color: #0D6EFD;
            color: #fff;
            border: thin solid #0D6EFD;
        }
    </style>
    <div>
        <?php require('includes/navbar.php');?>
    </div>
    <div class="my-5 text-center">
        <img class="d-block mx-auto mb-4" width="250" src="images/logo.png" alt="">
        <span class="fs-1 fw-bold site-title">Services</span>
        <h1 class="display-5 fw-bold text-body-emphasis mb-4">Gentle Care, Radiant Smiles</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead fw-bolder mb-4">Transforming Lives, One Smile at a Time: Your Journey to a Healthier, Happier You Starts Right Here.</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            </div>
        </div>
    </div>
    <!-- service offered section -->
    <div class="container px-4 py-5" id="custom-cards service">
        <h2 class="pb-2 border-bottom">Dental Services</h2>
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
        <?php
            $start = 0;
            $items_per_page = 3;
            
            $records = $con->query("SELECT * FROM `services` WHERE `status`");
            
            $num_of_rows = $records->num_rows;
            $pages = ceil($num_of_rows / $items_per_page);
            
            if(isset($_GET["page-nr"])){
                $page = $_GET["page-nr"] -1;
                $start = $page * $items_per_page;
            }
            $service_res = select("SELECT * FROM `services` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT $start, $items_per_page",[1,0],'ii');


            while($service_data = mysqli_fetch_assoc($service_res)){

                // get service thumbnail
                $service_thumb = SERVICES_IMG_PATH."banner.png";
                $thumb_q = mysqli_query($con,"SELECT * FROM `service_images` 
                    WHERE `service_id`='$service_data[id]' 
                    AND `thumb`='1'");
                if(mysqli_num_rows($thumb_q)>0){
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $service_thumb = SERVICES_IMG_PATH.$thumb_res['image'];
                }
                $book_btn = '';

                if(!$setting_r['shutdown']){
                    $login=0;
                    if(isset($_SESSION['login']) && $_SESSION['login']==true){
                        $login=1;
                    }
                    $book_btn = "<button onclick='checkLoginToBook($login,$service_data[id])' class='btn btn-sm text-white custom-bg shadow-none'>Schedule Appointment Now</button>";
                }

                $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review` WHERE `service_id`='$service_data[id]' ORDER BY `id` DESC LIMIT 20";
                $rating_res = mysqli_query($con,$rating_q);
                $rating_fetch =mysqli_fetch_assoc($rating_res);

                $rating_data = "";

                if($rating_fetch['avg_rating']!= NULL){
                    $rating_data = "<div class='rating mb-4'>
                                        <span class='badge rounded-pill bg-light'>
                                    ";

                    for($i=0;  $i < $rating_fetch['avg_rating']; $i++){
                        $rating_data .= "<i class='bi bi-star-fill text-warning'></i> ";
                    }

                    $rating_data .= "</span>
                                    </div>";
                }else{
                    $rating_data ="<div class='rating mb-4'>
                                        <span class='badge rounded-pill bg-dark'>NO RATINGS YET!</span>
                                    </div>";
                }

                $description = $service_data['description'];
                $maxLength = 200;
                $truncatedData = substr($description, 0, $maxLength);

                $price = $service_data['price'];
                $formatedPrice = number_format($price,2,'.',',');



                echo<<<serdata
                <div class="container">
                    <div class="row">
                        <div class="card col-lg-4 col-md-6 col-sm-12 mb-3" style="width: 25rem;">
                            <img src="$service_thumb" class="card-img-top" alt="...">
                            <div class="card-body">
                                <div class="d-flex align-content-center justify-content-between mb-2">
                                    <h3 class="display-6 lh-1 fw-bold">$service_data[name]</h3>
                                    <h6 class="mb-4 fw-medium">₱$formatedPrice</h6>
                                </div>
                                <p class="card-text">$truncatedData...</p>
                                $rating_data
                                <hr class="text-light-sm">
                                <div class="d-flex justify-content-between mb-2">
                                    <a href="service_details.php?id=$service_data[id]" class="btn btn-sm btn-outline-dark shadow-none ">More details</a>
                                    $book_btn
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                serdata;
            }
        
        ?>
        </div>
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
    
                <div class="page-numbers">
                    <?php
                        for($counter = 1; $counter <= $pages; $counter++){
                    ?>
                        <a href="?page-nr=<?php echo $counter?>" class="text-decoration-none btn btn-outline-primary mx-1"><?php echo $counter?></a>
                    <?php
                    }
                    ?>
                </div>
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
    <?php require('includes/footer.php');?>
    <script>
        let links =document.querySelectorAll('.page-numbers > a');
        let bodyId =parseInt(document.body.id) - 1;
        links[bodyId].classList.add("actived");
    </script>
</body>
</html>