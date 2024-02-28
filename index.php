<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/custom.css">
    <?php require('includes/links.php');?>
    <title>DentalPal</title>
</head>
<body>
    <style>
        .site-title{
            color: rgb(165,16,18);
        }
    </style>
    <div>
        <?php require('includes/navbar.php');?>
    </div>
    <!-- hero section -->
    <div class="px-4 py-5 text-center">
        <img class="d-block mx-auto mb-4" src="images/logo.png" width="250px" alt="">
        <span class="fs-1 fw-bold site-title">DentalPal</span>
        <h1 class="display-5 fw-bold text-body-emphasis">Your Brighter, Healthier Smile Awaits</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">Discover a Dental Experience Unlike Any Other, Where Compassion, Expertise, and Innovation Combine to Give You the Smile of Your Dreams.</p>
        </div>
    </div>

    <!-- service offered section -->
    <div class="container px-4 py-5" id="custom-cards service">
        <h2 class="pb-2 border-bottom">Dental Services</h2>
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
            <?php
                // $service_res = select("SELECT * FROM `services` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3",[1,0],'ii');

                // while($service_data = mysqli_fetch_assoc($service_res)){

                //     //get service thumbnail
                //     $service_thumb = SERVICES_IMG_PATH."thumbnail.jpg";
                //     $thumb_q = mysqli_query($con,"SELECT * FROM `service_image` 
                //         WHERE `service_id`='$service_data[id]' 
                //         AND `thumb`='1'");
                //     if(mysqli_num_rows($thumb_q)>0){
                //         $thumb_res = mysqli_fetch_assoc($thumb_q);
                //         $service_thumb = SERVICES_IMG_PATH.$thumb_res['image'];
                //     }
                //         echo<<<serdata
                //         <div class="container">
                //             <div class="row">
                //                 <div class="card col-lg-4 col-md-6 col-sm-12" style="width: 25rem;">
                //                     <img src="$service_thumb" class="card-img-top" alt="...">
                //                     <div class="card-body">
                //                         <h3 class="display-6 lh-1 fw-bold">$service_data[name]</h3>
                //                         <h5 class="mb-4 fw-bold">₱$service_data[price]</h5>
                //                         <p class="card-text">$service_data[description]</p>
                //                     </div>
                //                 </div>
                //             </div>
                //         </div>
                //         serdata;
                // }
            
            ?>
            <div class="container">
                <div class="row">
                    <div class="card col-lg-4 col-md-6 col-sm-12" style="width: 25rem;">
                        <img src="./images/banner.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h3 class="display-6 lh-1 fw-bold">Service Name</h3>
                            <h5 class="mb-4 fw-bold">₱100.00</h5>
                            <p class="card-text">At DentalPal, we offer a comprehensive range of dental services to meet all your oral health needs. Whether you require routine dental cleanings, preventive care, or more complex restorative and cosmetic procedures, our experienced team is here to ensure your smile remains healthy and radiant.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="card col-lg-4 col-md-6 col-sm-12" style="width: 25rem;">
                        <img src="./images/banner.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h3 class="display-6 lh-1 fw-bold">Service Name</h3>
                            <h5 class="mb-4 fw-bold">₱100.00</h5>
                            <p class="card-text">At DentalPal, we offer a comprehensive range of dental services to meet all your oral health needs. Whether you require routine dental cleanings, preventive care, or more complex restorative and cosmetic procedures, our experienced team is here to ensure your smile remains healthy and radiant.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="card col-lg-4 col-md-6 col-sm-12" style="width: 25rem;">
                        <img src="./images/banner.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h3 class="display-6 lh-1 fw-bold">Service Name</h3>
                            <h5 class="mb-4 fw-bold">₱100.00</h5>
                            <p class="card-text">At DentalPal, we offer a comprehensive range of dental services to meet all your oral health needs. Whether you require routine dental cleanings, preventive care, or more complex restorative and cosmetic procedures, our experienced team is here to ensure your smile remains healthy and radiant.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="container" id="custom-cards service">
        <div class="row">
            <h2 class="pb-2 border-bottom fw-bold">Dental Services</h2>
            <div class="col-lg-6 col-12" style="width: 25rem;">
                <img src="images/logo.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h3 class="display-6 lh-1 fw-bold">Service Name</h3>
                    <h5 class="mb-4 fw-bold">₱ Price</h5>
                    <p class="card-text">service description</p>
                </div>
            </div>
            <div class="col-lg-6 col-12" style="width: 25rem;">
                <img src="images/logo.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h3 class="display-6 lh-1 fw-bold">Service Name</h3>
                    <h5 class="mb-4 fw-bold">₱ Price</h5>
                    <p class="card-text">service description</p>
                </div>
            </div>
            <div class="col-lg-6 col-12" style="width: 25rem;">
                <img src="images/logo.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h3 class="display-6 lh-1 fw-bold">Service Name</h3>
                    <h5 class="mb-4 fw-bold">₱ Price</h5>
                    <p class="card-text">service description</p>
                </div>
            </div>
        </div>
    </div> -->


    <!-- location offered section -->
    <div class="container px-4 py-5" id="custom-cards">
        <h2 class="pb-2 border-bottom">Location</h2>
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
            <iframe class="w-100 rounded" src="https://www.google.com/maps/embed?pb=!4v1708656065406!6m8!1m7!1slI1eJG2HM3K7FTCEuCnhfg!2m2!1d13.17490973774465!2d121.2788460721744!3f5.762094202870658!4f-2.539169865683263!5f0.7820865974627469" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <?php require('includes/footer.php');?>
    <script src="js/login_register.js"></script>
</body>
</html>