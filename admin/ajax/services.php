<?php

    require('../includes/essentials.php');
    require('../includes/dbConfig.php'); 
    adminLogin();


    if(isset($_POST['add_service']))
    {
        $frm_data = filteration($_POST);
        $flag = 0;

        $q1 = "INSERT INTO `services` (`name`, `price`, `description`) VALUES (?,?,?)";
        $values = [$frm_data['name'],$frm_data['price'],$frm_data['description']];

        if(insert($q1,$values,'sis')){
            $flag = 1;
        }

        if($flag){
            echo 1;
        }else{
            echo 0;
        }
    }

    if(isset($_POST['get_all_services'])){
        $res = select("SELECT * FROM `services` WHERE `removed`=?",[0],'i');
        $i=1;

        $data="";

        while($row = mysqli_fetch_assoc($res)){

            if($row['status']==1){
                $status = "
                    <button onclick='toggle_status($row[id],0)' class='btn btn-success btn-sm shadow-none'>Active</button>
                ";
            }else{
                $status = "
                    <button onclick='toggle_status($row[id],1)' class='btn btn-warning btn-sm shadow-none'>Inactive</button>
                ";
            }

            $price = $row['price'];
            $formatedPrice = number_format($price,2,'.',',');

            $data.="
                <div class='col-lg-6 col-md-12 mb-4 mt-2'>
                    <div class='p-3 rounded shadow'>
                        <div class='d-flex justify-content-between align-items-center mb-3'>
                            <h5 class='card-title'>$row[name]</h5>
                            $status
                        </div>
                        <div class='d-flex justify-content-between align-items-center'>
                            <div class=''>
                                <h6 class='card-subtitle text-body-secondary'><b>Dimaano Dental Clinic</b></h6>
                                <h6 class='card-subtitle mb-2 text-body-secondary'>$formatedPrice</h6>
                            </div>
                            <div class='d-flex justify-content-between align-items-center'>
                                <button type='button' onclick='edit_details($row[id])' class='btn btn-primary shadow-none btn-sm me-2' data-bs-toggle='modal' data-bs-target='#edit-service'>
                                    <i class='bi bi-pencil-square'></i>
                                </button>
                                <button type='button' onclick=\"service_images($row[id], '$row[name]')\" class='btn btn-info shadow-none btn-sm me-2' data-bs-toggle='modal' data-bs-target='#service-image'>
                                    <i class='bi bi-images'></i>
                                </button>
                                <button type='button' onclick='remove_service($row[id])' class='btn btn-danger shadow-none btn-sm me-2'>
                                    <i class='bi bi-trash'></i>
                                </button>
                                <a href='service_history.php?id=$row[id]' class='btn btn-outline-secondary shadow-none btn-sm border-0'><i class='bi bi-eye fs-5'></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            ";
            $i++;
        }
        echo $data;
    }

    if(isset($_POST['get_service'])){
        $frm_data = filteration($_POST);
        $res1 = select("SELECT * FROM `services` WHERE `id`=?",[$frm_data['get_service']],'i');

        $servicedata = mysqli_fetch_assoc($res1);

        $data = ["serviceData" => $servicedata];

        $data = json_encode($data);

        echo $data;
    }

    if(isset($_POST['edit_service'])){
        $frm_data = filteration($_POST);
        $flag = 0;

        $q1 = "UPDATE `services` SET `name`=?, `price`=?, `description`=? WHERE `id`=?";
        $values = [$frm_data['name'],$frm_data['price'],$frm_data['description'],$frm_data['service_id']];

        if(update($q1,$values,'sisi')){
            $flag = 1;
        }
        

        if($flag){
            echo 1;
        }else{
            echo 0;
        }
    }

    if(isset($_POST['toggle_status'])){
        $frm_data = filteration($_POST);

        $q = "UPDATE `services` SET `status`=? WHERE `id`=?";
        $v = [$frm_data['value'],$frm_data['toggle_status']];

        if(update($q,$v,'ii')){
            echo 1;
        }else{
            echo 0;
        }
    }

    if(isset($_POST['add_image']))
    {
        $frm_data = filteration($_POST);

        $img_r = uploadImage($_FILES['image'],SERVICES_FOLDER);

        if($img_r == 'inv_img'){
            echo $img_r;
        }else if($img_r == 'inv_size'){
            echo $img_r;
        }else if($img_r == 'upd_failed'){
            echo $img_r;
        }else{
            $q = "INSERT INTO `service_images` (`service_id`, `image`) VALUES (?,?)";
            $values = [$frm_data['service_id'],$img_r];
            $res = insert($q, $values,'is');
            echo $res;
        }
    }

    if(isset($_POST['get_service_images'])){
        $frm_data = filteration($_POST);
        $res = select("SELECT * FROM `service_images` WHERE `service_id`=?",[$frm_data['get_service_images']],'i');

        $path = SERVICES_IMG_PATH;
        
        while($row = mysqli_fetch_assoc($res)){
            if($row['thumb']==1){
                $thumb_btn = "<i class='bi bi-check-lg text-light bg-success px-2 py-1 rounded fs-5'></i>";
            }else{
                $thumb_btn = "<button onclick='thumb_image($row[id],$row[service_id])' class='btn btn-secondary shadow-none'><i class='bi bi-check-lg'></i></button>";
            }
            echo<<<data
                <tr class='align-middle'>
                    <td><img src='$path$row[image]' class='img-fluid'></td>
                    <td>$thumb_btn</td>
                    <td>
                        <button onclick='rem_image($row[id],$row[service_id])' class='btn btn-danger shadow-none'><i class='bi bi-trash'></i></button>
                    </td>
                </tr>
            data;
        }
    }

    if(isset($_POST['rem_image']))
    {
        $frm_data = filteration($_POST);
        $values = [$frm_data['image_id'],$frm_data['service_id']];

        $pre_q = "SELECT * FROM `service_images` WHERE `id`=? AND `service_id`=?";
        $res = select($pre_q, $values, 'ii');
        $img = mysqli_fetch_assoc($res);

        if(deleteImage($img['image'],SERVICES_FOLDER)){
        $q = "DELETE FROM `service_images` WHERE `id` =? AND `service_id`=?";
        $res = delete($q, $values, 'ii');
        echo $res;
        }else{
        echo 0;
        }
    }

    if(isset($_POST['thumb_image']))
    {
        $frm_data = filteration($_POST);

        $pre_q = "UPDATE `service_images` SET `thumb`=? WHERE `service_id`=?";
        $pre_v = [0,$frm_data['service_id']];
        $pre_res =  update($pre_q,$pre_v,'ii');

        $q = "UPDATE `service_images` SET `thumb`=? WHERE `id`=? AND `service_id`=?";
        $v = [1,$frm_data['image_id'],$frm_data['service_id']];
        $res =  update($q,$v,'iii');

        echo $pre_res;
    }
    
    if(isset($_POST['remove_service'])){
        $frm_data = filteration($_POST);

        $res1 = select("SELECT * FROM `service_images` WHERE `service_id`=?",[$frm_data['service_id']],'i');
        while($row = mysqli_fetch_assoc($res1)){
            deleteImage($row['image'],SERVICES_FOLDER);
        }
        $res2 = delete("DELETE FROM `service_images` WHERE  `service_id`=?",[$frm_data['service_id']],'i');
        $res5 = update("UPDATE `services` SET `removed`=? WHERE  `id`=?",[1,$frm_data['service_id']],'ii');

        if($res5){
            echo 1;
        }else{
            echo 0;
        }

    }

?>