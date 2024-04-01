<?php
    require('includes/essentials.php');

    // adminLogin();
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
<body class="bg-white">
    <?php 
        require('includes/header.php');
    ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <!--shutdown section-->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Shutdown Website</h5>
                            <div class="form-check form-switch">
                                <form action="">
                                    <input onchange="upd_shutdown(this.value)" class="form-check-input shadow-none" type="checkbox" id="shutdown_toggle">
                                </form>
                            </div>
                        </div>
                        <p class="card-text" > No patients will be allowed to set appointment, when shutdown mode is turned on.</p>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mt-5 px-4">
                    <div class="card-body">
                        <form id="pass-form">
                            <h5 class="mb-3 fw-bold">Change Password</h5>
                            <div class="row">
                                <div class="form-floating col-md-6 mb-3 ps-0"> 
                                    <input type="password" name="new_pass" class="form-control shadow-none" id="oldpassInput" placeholder="" required>
                                    <label for="nameInput">New Password</label>
                                </div>
                                <div class="form-floating col-md-6 mb-3 ps-0"> 
                                    <input type="password" name="confirm_pass" class="form-control shadow-none" id="newpassInput" placeholder="" required>
                                    <label for="nameInput">Confirm Password</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-dark shadow-none mt-4">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php require('includes/scripts.php');?>
    <script src="scripts/settings.js"></script>
    <script>
        let pass_form = document.getElementById('pass-form');
        pass_form.addEventListener('submit', function(e){
        e.preventDefault();

        let new_pass = pass_form.elements['new_pass'].value;
        let confirm_pass = pass_form.elements['confirm_pass'].value;

        if(new_pass != confirm_pass){
            alert('error', 'Password NOT MATCH!');
            return false;
        }
        
        let data = new FormData();
        data.append('pass_form', '');
        data.append('new_pass', new_pass);
        data.append('confirm_pass', confirm_pass);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/settings_crud.php", true);

        xhr.onload = function(){
            if(this.responseText == 'mismatch'){
                alert('error', "Password do not match");
            }else if(this.responseText == 0){
                alert('error', "Update Failed");
            }else{
                alert('success', "Password Updated");
            }
            
        }
        xhr.send(data);
    });
    </script>
</body>
</html>