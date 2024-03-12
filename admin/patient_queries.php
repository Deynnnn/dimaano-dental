<?php
    require('includes/essentials.php');
    require('includes/dbConfig.php');

    adminLogin();

    if(isset($_GET['seen'])){
        $frm_data = filteration($_GET);

        if($frm_data['seen']=='all'){
            $q = "UPDATE `patient_queries` SET `seen`=?";
            $values = [1];
            if(update($q,$values,'i')){
                alert('success', 'Marked all as read');

            }else{
                alert('error', 'All mails have already read');
            }
        }else{
            $q = "UPDATE `patient_queries` SET `seen`=? WHERE `sr_no`=?";
            $values = [1,$frm_data['seen']];
            if(update($q,$values,'ii')){
                alert('success', 'Marked as read');

            }else{
                alert('error', 'Operation Failed');
            }
        }
    }

    if(isset($_GET['del'])){
        $frm_data = filteration($_GET);

        if($frm_data['del']=='all'){
            $q = "DELETE FROM `patient_queries`";
            if(mysqli_query($con,$q)){
                alert('success', 'All Inquiry Deleted');

            }else{
                alert('error', 'Operation Failed');
            }
        }else{
            $q = "DELETE FROM `patient_queries` WHERE `sr_no`=?";
            $values = [$frm_data['del']];
            if(delete($q,$values,'i')){
                alert('success', 'Inquiry Deleted');

            }else{
                alert('error', 'Operation Failed');
            }
        }
    }
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
                <h4 class="mb-4">GUEST MAILS</h4>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                    <div class="text-end mb-4">
                        <a href="?seen=all" class="btn btn-dark text-light rounded-pill shadow-none btn-sm"><i class="bi bi-check-all"></i> Mark all as read</a>
                        <a href="?del=all" class="btn btn-secondary text-light rounded-pill shadow-none btn-sm"><i class="bi bi-x-circle"></i> Delete all Mails</a>
                    </div>
                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover">
                                <thead class="sticky-top">
                                    <tr class=" text-white" style="background-color: rgb(100,20,22);">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" width="20%">Subject</th>
                                    <th scope="col" width="30%">Message</th>
                                    <th scope="col">Date</th>
                                    <th scope="col" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $q = "SELECT * FROM `patient_queries` ORDER BY `sr_no` DESC";
                                        $data = mysqli_query($con,$q);
                                        $i=1;

                                        while($row = mysqli_fetch_assoc($data)){
                                            $seen ='';
                                            if($row['seen']!=1){
                                                $seen = "<a href='?seen=$row[sr_no]' class='btn btn-sm rounded-pill btn-success'>Mark as read</a>";
                                            }else{
                                                $seen = "<p href='?seen=$row[sr_no]' class='rounded-pill text-decoration-none text-dark user-select-none'>Read</p>";
                                            }
                                            $seen.="<a href='?del=$row[sr_no]' class='btn btn-sm rounded-pill btn-danger mt-2'>Delete</a>";
                                            echo<<<query
                                                <tr>
                                                    <td>$i</td>
                                                    <td>$row[name]</td>
                                                    <td>$row[email]</td>
                                                    <td>$row[subject]</td>
                                                    <td>$row[message]</td>
                                                    <td>$row[created_at]</td>
                                                    <td>$seen</td>
                                                </tr>
                                            query;
                                            $i++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php require('includes/scripts.php');?>
    <script src="scripts/dashboard.js"></script>
</body>
</html>