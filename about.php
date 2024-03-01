<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('includes/links.php');?>
    <title>DentalPal - About Us</title>
</head>
<body>
    <style>
        .site-title{
            color: rgb(165,16,18);
        }
        .custom-alert{
            position: fixed;
            top: 80px;
            right: 25px;
            z-index: 11;
        }
        .active{
            border-bottom: 3px solid rgb(164,15,17);
            transition: .15s;
        }
    </style>
    <div>
        <?php require('includes/navbar.php');?>
    </div>
    <div class="my-5 text-center">
        <img class="d-block mx-auto mb-4" width="250" src="images/logo.png" alt="">
        <span class="fs-1 fw-bold site-title">About Us</span>
        <h1 class="display-5 fw-bold text-body-emphasis mb-4">Gentle Care, Radiant Smiles</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead fw-bolder mb-4">Transforming Lives, One Smile at a Time: Your Journey to a Healthier, Happier You Starts Right Here.</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            </div>
        </div>
    </div>
    <!-- service offered section -->
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 ">
                    <form method="POST">
                        <h5>Send a Message</h5>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Name</label>
                            <input type="text" class="form-control shadow-none" name="name" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Email</label>
                            <input type="email" class="form-control shadow-none" name="email" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Subject</label>
                            <input type="text" class="form-control shadow-none" name="subject" required >
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Message</label>
                            <textarea class="form-control shadow-none" rows="5" style="resize: none;" name="message" required></textarea>
                        </div>
                        <button type="submit" name="send" class="btn btn-outline-dark mt-4">SEND</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <iframe class="w-100 rounded mb-4" height="320px" src="https://www.google.com/maps/embed?pb=!4v1708656065406!6m8!1m7!1slI1eJG2HM3K7FTCEuCnhfg!2m2!1d13.17490973774465!2d121.2788460721744!3f5.762094202870658!4f-2.539169865683263!5f0.7820865974627469" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <h5>Address</h5>
                    <a href="#" target="_blank" class="d-inline-block text-decoration-none text-dark">
                        <i class="bi bi-geo-alt-fill"></i> Poblacion 1 Victoria Oriental Mindoro
                    </a>

                    <h5 class="mt-4">Call us</h5>
                    <a href="tel: 09958829014" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> 09958829014
                    </a>
                    <br>

                    <h5 class="mt-4">Email</h5>
                    <a href="mailto: dimaanoDental@gmail.com" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-envelope-fill"></i></a> dimaanoDental@gmail.com

                    <h5 class="mt-4">Follow us</h5>
                    <a href="https://www.facebook.com/dimaanodentalclinic" target="_blank" class="d-inline-block mb-3 text-dark fs-5 me-2 text-decoration-none">
                        <i class="bi bi-facebook me-1"></i> Facebook
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['send'])){
            $frm = filteration($_POST);
            $q = "INSERT INTO `patient_queries` (`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
            $values = [$frm['name'],$frm['email'],$frm['subject'],$frm['message']];
            $res = insert($q,$values,'ssss');

            if($res == 1){
                alert('success', 'Mail sent!');
            }else{
                alert('error', 'Server Down! try again later.');
            }
        }
    ?>
    <?php require('includes/footer.php');?>
</body>
</html>