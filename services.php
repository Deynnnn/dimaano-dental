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
    <?php require('includes/footer.php');?>
</body>
</html>