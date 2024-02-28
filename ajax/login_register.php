<?php
    require ('../admin/includes/dbConfig.php');
    require ('../admin/includes/essentials.php');
    date_default_timezone_set("Asia/Manila");


    if (isset($_POST['register'])){
        $data = filteration($_POST);

        // Password checker
        if ($data['password'] != $data['cPassword']) {
            echo 'password_mismatch';
            exit;
        }

        // User checker {existing/not}
        $u_exist = select("SELECT * FROM `patients` WHERE `email`=? OR `conNum`=? LIMIT 1", [$data['email'], $data['conNum']], 'ss');

        if (mysqli_num_rows($u_exist) != 0) {
            $u_exist_fetch = mysqli_fetch_assoc($u_exist);
            echo ($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
            exit;
        }

        // Send confirmation link to user's email
        $token = bin2hex(random_bytes(16));

        // if (!send_mail($data['email'], $token, "email_confirmation")) {
        //     echo 'mail_failed';
        //     exit;
        // }

        $enc_pass = password_hash($data['password'], PASSWORD_BCRYPT);

        $query = "INSERT INTO `patients`(`name`, `email`, `address`, `conNum`, `dob`, `password`, `token`) VALUES (?,?,?,?,?,?,?)";
        $values = [$data['name'], $data['email'], $data['address'], $data['conNum'], $data['birthday'], $enc_pass, $token];

        if (insert($query, $values, 'sssssss')) {
            echo 1;
        } else {
            echo 'ins_failed';
        }
    }

    if (isset($_POST['login'])){
        $data = filteration($_POST);

        // User checker {existing/not}
        $u_exist = select("SELECT * FROM `patients` WHERE `email`=? OR `conNum`=? LIMIT 1", [$data['email_phone'], $data['email_phone']], 'ss');

        if(mysqli_num_rows($u_exist) == 0) {
            echo 'inv_email_mob';
            exit;
        }else{
            $u_fetch = mysqli_fetch_assoc($u_exist);
            if($u_fetch['is_verified']==0){
                echo 'not_verfied';
            }else if($u_fetch['status']==0){
                echo 'inactive';
            }else{
            if(!password_verify($data['password'],$u_fetch['password'])){
                echo 'invalid_pass';
            }else{
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['uId'] = $u_fetch['id'];
                    $_SESSION['uName'] = $u_fetch['name'];
                    $_SESSION['uPhone'] = $u_fetch['conNum'];
                    echo 1;
                }
            }
        }
    }
?>