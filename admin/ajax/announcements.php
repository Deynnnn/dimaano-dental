<?php

    require('../includes/essentials.php');
    require('../includes/dbConfig.php'); 
    adminLogin();


    if(isset($_POST['add_announcements']))
    {
        $frm_data = filteration($_POST);
        $flag = 0;

        $q1 = "INSERT INTO `announcements` (`title`, `description`) VALUES (?,?)";
        $values = [$frm_data['name'],$frm_data['description']];

        if(insert($q1,$values,'ss')){
            $flag = 1;
        }

        if($flag){
            echo 1;
        }else{
            echo 0;
        }
    }

    if(isset($_POST['get_all_services'])){
        $res = select("SELECT * FROM `announcements` WHERE `removed`=?",[0],'i');
        $i=1;

        $data="";

        while($row = mysqli_fetch_assoc($res)){

            if($row['status']==1){
                $status = "
                    <button onclick='toggle_status($row[id],0)' class='btn btn-success btn-sm shadow-none'>active</button>
                ";
            }else{
                $status = "
                    <button onclick='toggle_status($row[id],1)' class='btn btn-warning btn-sm shadow-none'>inactive</button>
                ";
            }

            $data.="
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>$row[title]</td>
                    <td>$row[description]</td>
                    <td>$status</td>
                    <td>
                        <button type='button' onclick='edit_details($row[id])' class='btn btn-primary shadow-none btn-sm mb-2' data-bs-toggle='modal' data-bs-target='#edit-service'>
                            <i class='bi bi-pencil-square'></i>
                        </button>
                        <button type='button' onclick='remove_service($row[id])' class='btn btn-danger shadow-none btn-sm mb-2'>
                            <i class='bi bi-trash'></i>
                        </button>
                    <td>
                </tr>
            ";
            $i++;
        }
        echo $data;
    }

    if(isset($_POST['get_service'])){
        $frm_data = filteration($_POST);
        $res1 = select("SELECT * FROM `announcements` WHERE `id`=?",[$frm_data['get_service']],'i');

        $servicedata = mysqli_fetch_assoc($res1);

        $data = ["serviceData" => $servicedata];

        $data = json_encode($data);

        echo $data;
    }

    if(isset($_POST['edit_service'])){
        $frm_data = filteration($_POST);
        $flag = 0;

        $q1 = "UPDATE `announcements` SET `title`=?, `description`=? WHERE `id`=?";
        $values = [$frm_data['name'],$frm_data['description'],$frm_data['announcement_id']];

        if(update($q1,$values,'ssi')){
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

        $q = "UPDATE `announcements` SET `status`=? WHERE `id`=?";
        $v = [$frm_data['value'],$frm_data['toggle_status']];

        if(update($q,$v,'ii')){
            echo 1;
        }else{
            echo 0;
        }
    }
    
    if(isset($_POST['remove_service'])){
        $frm_data = filteration($_POST);

        $res5 = update("UPDATE `announcements` SET `removed`=? WHERE  `id`=?",[1,$frm_data['announcement_id']],'ii');

        if($res5){
            echo 1;
        }else{
            echo 0;
        }

    }

?>