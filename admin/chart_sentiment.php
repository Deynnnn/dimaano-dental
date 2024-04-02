<?php
    require('includes/essentials.php');
    require('includes/dbConfig.php');
    include('../sentiment/vendor/autoload.php');
    Use Sentiment\Analyzer;
    $analyzer = new Analyzer(); 
?>
<?php
if (!$con) {
    # code...
    echo "Problem in database connection! Contact administrator!" . mysqli_error();
}
else{
        $ps = 0;
        $neu = 0;
        $neg = 0;
        $sent_arr = ["positive", "neutral", "negative"];
        $result = mysqli_query($con,"SELECT * FROM rating_review");
        while($row = mysqli_fetch_array($result))
        {           
            $output_text = $analyzer->getSentiment($row['review'],$row['rating']);
            // Access the sentiment values from the output
            $positive = $output_text['pos'];
            $negative = $output_text['neg'];
            $neutral = $output_text['neu'] - 0.2;
            if($positive >= 0.4){
                $positive += 0.2;
            }
            else if($negative >= 0.4){
                $negative += 0.2;
            }
            else if($neutral >= 0.3){
            }
                $ps += $positive;
                $neu += $neutral;
                $neg += $negative;
        }
        $result_arr = [round($ps, 3), round($neu, 3), round($neg, 3)];
    }
?>
<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Graph</title> 
    </head>
    <body>
        <center>
        <h2 class="page-header" style="background-color: #595959; color: white; padding: 5px; margin-left: 20px;">Analytics Reports (Patients Feedback) </h2>
        <div style="width:80%;height:15%;text-align:center">
            <canvas width="100%" height="48px" id="chartjs_bar1"></canvas>
        </div>    
        </center>
    </body>
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script type="text/javascript">

var ctx = document.getElementById("chartjs_bar1").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels:<?php echo json_encode($sent_arr); ?>,
            datasets: [{
                backgroundColor: [
                    "#74BE55",
                    "#F2C933",
                    "#ED334D",
                ],
                label:<?php echo json_encode("Total"); ?>,
                data:<?php echo json_encode($result_arr); ?>,
                
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
                legend: {
                display: false,
                position: 'bottom',

                labels: {
                    fontColor: '#71748d',
                    fontFamily: 'Circular Std Book',
                    fontSize: 14,
                }
            },
        }
    });
</script>
</html>