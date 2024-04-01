<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/custom.css">
    <?php require('includes/links.php');?>
    <title>DentalPal - Profile</title>
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
    </style>
    <div>
        <?php 
        require('includes/navbar.php') ;
        if(!(isset($_SESSION['login']) || $_SESSION['login'] == 'true')){
            redirect('index.php');
        }

        $patient_exist = select("SELECT * FROM `patients` WHERE `id`=? LIMIT 1", [$_SESSION['uId']],'s');

        if(mysqli_num_rows($patient_exist) == 0){ 
            redirect('index.php');
        }

        $patient_fetch = mysqli_fetch_assoc($patient_exist);
        
        ?>
    </div>

    <div class="container">
        <div class="row"> 
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">PROFILE</h2>

                <div style="font-size: 14px;">
                    <a href="index.php" class="text-decoration-none text-secondary">
                        HOME >
                    </a>
                    <a href="#" class="text-decoration-none text-secondary">
                        PROFILE
                    </a>
                </div>
            </div>

            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="info-form">
                        <h5 class="mb-3 fw-bold">Basic Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" value="<?php echo $patient_fetch['first_name']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" value="<?php echo $patient_fetch['last_name']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Contact Number</label>
                                <input type="number" name="conNum" value="<?php echo $patient_fetch['conNum']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" value="<?php echo $patient_fetch['dob']?>" class="form-control shadow-none" placeholder="" required>
                            </div>
                            <div class="col-md-8 mb-4">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo $patient_fetch['address']?></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-dark shadow-none">Save Changes</button>
                    </form>
                </div>
            </div>

            <div class="col-md-8 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="pass-form">
                        <h5 class="mb-3 fw-bold">Change Password</h5>
                        <div class="row">
                        <div class="col-md-6 mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_pass" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_pass" class="form-control shadow-none" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-dark shadow-none mt-4">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require('includes/footer.php');?>
    <script>
        let info_form = document.getElementById('info-form');
        info_form.addEventListener('submit', function(e){
            e.preventDefault();

            let data = new FormData();
            data.append('info_form', '');
            data.append('first_name',info_form.elements['first_name'].value);
            data.append('last_name',info_form.elements['last_name'].value);
            data.append('conNum',info_form.elements['conNum'].value);
            data.append('address',info_form.elements['address'].value);
            data.append('dob',info_form.elements['dob'].value);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/profile.php", true);

            xhr.onload = function(){
                if(this.responseText == 'phone_already'){
                    alert('error', "Phone number is already been used by another user");
                }else if(this.responseText == 0){
                    alert('error', "No Changes Made!");
                }else{
                    alert('success', "Changes Saved!");
                }
                
            }
            xhr.send(data);
        });

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
            xhr.open("POST", "ajax/profile.php", true);

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