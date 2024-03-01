<?php
    require('includes/dbConfig.php');
    require('includes/essentials.php');

    session_start();

    // if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
    //     redirect('dashboard.php');
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DentalPal - Admin Login</title>
    <?php require('includes/links.php');?>
    <style>
        .login-form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            
        }
        .custom-bg{
            background-color:  rgb(165,16,18);
            border: 1px solid  rgb(165,16,18);
        }
        .custom-bg:hover{
            background-color:  rgb(165,16,18,.85);
            border: 1px solid  rgb(165,16,18)
        }
        .custom-alert{
            position: fixed;
            top: 25px;
            right: 25px;
        }
    </style>
</head>
<body>
    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form method="POST">
            <h4 class="text-white py-3" style="background-color:  rgb(165,16,18);">ADMIN LOGIN PANEL</h4>
            <div class="p-4">
                <div class="mb-3 form-floating col-md-12 ps-0"> 
                    <input type="email" name="email" class="form-control shadow-none" id="nameInput" placeholder="name@example.com" required>
                    <label for="nameInput">Email</label>
                </div>
                <div class="mb-3 form-floating col-md-12 ps-0"> 
                    <input type="password" name="password" class="form-control shadow-none" id="passwordInput" placeholder="password" required>
                    <label for="passwordInput">Password</label>
                </div>
                <button class="btn custom-bg shadow-none text-light" name='login'type='submit'>LOGIN</button>
            </div>
        </form>
    </div>

    <?php
    
        if(isset($_POST['login'])){
            $frm_data = filteration($_POST);

            $query = "SELECT * FROM `admin` WHERE `email`=? AND `password`=?";
            $values = [$frm_data ['email'], $frm_data['password']];

            $res = select($query,$values,"ss");
            if($res->num_rows==1){
                $row = mysqli_fetch_assoc($res);
                $_SESSION['adminLogin'] = true;
                $_SESSION['adminId'] = $row['id'];
                redirect('dashboard.php');
            }else{
                alert("error", "Incorrect email or password - Please check and try again!");
            }
        }

    ?>
    <?php require('includes/scripts.php')?>

</body>
</html>