<!-- bootstrap links -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- bootstrap icon link -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<!-- fontawesome -->
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<!-- icon link -->
<link rel="shortcut icon" href="/images/logo.png" type="image/x-icon">
<link rel="stylesheet" href="/styles/custom.css">

<!-- calendar links -->
<?php 

    session_start();

    require('admin/includes/dbConfig.php');
    require('admin/includes/essentials.php');

    $setting_q = "SELECT * FROM `settings` WHERE `id`=?";
    $values = [1];
    $setting_r = mysqli_fetch_assoc(select($setting_q,$values, 'i'));

    if($setting_r['shutdown']){
        echo<<<alertbar
        <div class="bg-danger text-center p2 fw-bold text-light">
            <i class="bi bi-info-circle-fill"></i>
            The Doctor is out, Appointments are temporarily closed!
        </div>
        alertbar;
    }
?>