<?php
    require ('admin/includes/dbConfig.php');
    require ('admin/includes/essentials.php');

    if(isset($_GET['email_confirmation'])){
        $data = filteration($_GET);
    
        $query = select("SELECT * FROM `patients` WHERE `email`=? AND `token`=? LIMIT 1", [$data['email'], $data['token']], 'ss');
    
        if(mysqli_num_rows($query) == 1){
            $fetch = mysqli_fetch_assoc($query);
    
            if($fetch['is_verified'] == 1){
                echo "<script>alert('Email already verified!')</script>";
                redirect('index.php');
            }else{
                $update = update("UPDATE `patients` SET `is_verified`=? WHERE `id`=?", [1, $fetch['id']], 'ii');
                if($update){
                    echo "<script>alert('Email verification successful!')</script>";
                }else{
                    echo "<script>alert('Email verification failed! Server Down!')</script>";
                }
                redirect('index.php');
            }
        }else{
            echo "<script>alert('Invalid or Expired Link!')</script>";
            redirect('index.php');
        }
    }
?>