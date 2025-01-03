<?php
    require('includes/essentials.php');
    require('includes/dbConfig.php');
    include('../sentiment/vendor/autoload.php');
    Use Sentiment\Analyzer;
    $analyzer = new Analyzer(); 

    adminLogin();

    if(isset($_GET['seen'])){
        $frm_data = filteration($_GET);

        if($frm_data['seen']=='all'){
            $q = "UPDATE `rating_review` SET `seen`=?";
            $values = [1];
            if(update($q,$values,'i')){
                alert('success', 'Marked all as read');

            }else{
                alert('error', 'All mails have already read');
            }
        }else{
            $q = "UPDATE `rating_review` SET `seen`=? WHERE `sr_no`=?";
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
            $q = "DELETE FROM `rating_review`";
            if(mysqli_query($con,$q)){
                alert('success', 'All Inquiry Deleted');

            }else{
                alert('error', 'Operation Failed');
            }
        }else{
            $q = "DELETE FROM `rating_review` WHERE `sr_no`=?";
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
    <title>DentalPal - Rate Review</title>
    <?php require('includes/links.php');?>
    <style>
        .custom-alert{
            position: fixed;
            top: 80px;
            right: 25px;
            z-index: 9999;
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
<body style="background-color: rgb(248,247,250);">
    <?php 
        require('includes/header.php');
    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                
                
<div class="card border-0 mb-4">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-4">Rate and Review</h4>
            <div class="">
                <a href="?seen=all" class="btn btn-dark text-light rounded-pill shadow-none btn-sm"><i class="bi bi-check-all"></i> Mark all as read</a>
                <a href="?del=all" class="btn btn-secondary text-light rounded-pill shadow-none btn-sm"><i class="bi bi-x-circle"></i> Delete all Mails</a>
            </div>
        </div>

        <div class="table-responsive-md shadow-lg" style="height: 500px; overflow-y: scroll;">
            <table class="table table-hover">
                <thead class=" ">
                    <tr class="bg-dark text-white">
                    <th scope="col">#</th>
                    <th scope="col">Service Name</th>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Sentiment</th>
                    <th scope="col" width="30%">Review</th>
                    <th scope="col">Date</th>
                    <th scope="col" width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $q = "SELECT rr.*,uc.first_name AS uname, r.name AS rname FROM `rating_review` rr INNER JOIN `patients` uc ON rr.patient_id = uc.id INNER JOIN `services` r ON rr.service_id = r.id ORDER BY `id` DESC";

                        $data = mysqli_query($con,$q);
                        $i=1;

                        while($row = mysqli_fetch_assoc($data)){
                            $date = date('d-m-Y',strtotime($row['created_at']));

                            $seen ='';
                            if($row['seen']!=1){
                                $seen = "<a href='?seen=$row[id]' class='btn btn-sm rounded-pill btn-success mb-2'>Mark as read</a>";
                            }else{
                                $seen = "";
                            }
                            $seen.="<a href='?del=$row[id]' class='btn btn-sm rounded-pill btn-danger mt-2'>Delete</a>";

                            $output_text = $analyzer->getSentiment($row['review'],$row['rating']);
                            // Access the sentiment values from the output
                            $positive = $output_text['pos'];
                            $negative = $output_text['neg'];
                            $neutral = $output_text['neu'] - 0.2;
                            if($positive >= 0.4){
                            $positive += 0.2;
                                $sentiment = '<img src="../images/pos-sentiment.png" alt="" style="width: 100px; height: 85px;">';
                            }
                            else if($negative >= 0.4){
                                $sentiment = '<img src="../images/sad-sentiment.png" alt="" style="width: 100px; height: 85px;">';
                                $negative += 0.2;
                            }
                            else if($neutral >= 0.3){
                                $sentiment = '<img src="../images/neut-sentiment.png" alt="" style="width: 100px; height: 85px;"> <br> service meets patient expectations';
                            }

                            echo<<<query
                                <tr>
                                    <td>$i</td>
                                    <td>$row[rname]</td>
                                    <td>$row[uname]</td>
                                    <td>$row[rating]<i class="bi bi-star-fill text-warning"></i></td>
                                    <td>$sentiment<br> positive = $positive <br> neutral = $neutral <br> negative = $negative</td>
                                    <td>$row[review]</td>
                                    <td>$date</td>
                                    <td>$seen</td>
                                </tr>
                            query;
                            $i++;
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <?php require('ajax/sentiment.php');?>

        <div class="shadow-sm py-3 mt-5">
            <h4 class="mb-4 fw-bold">SENTIMENT ANALYSIS</h4>
            <iframe src="chart_sentiment.php" style="width: 100%; height: 600px;"></iframe>
        </div>
    </div>
</div>

    <?php require('includes/scripts.php');?>
</body>
</html>