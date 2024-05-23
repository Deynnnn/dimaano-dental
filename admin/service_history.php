<?php
    require('includes/essentials.php');
    require('includes/dbConfig.php');

    adminLogin();
    if(!isset($_GET['id'])){
        redirect('services.php');
    }

    $data = filteration($_GET);

    $service = select("SELECT * FROM `services` WHERE `id` = ?", [$data['id']], 'i');
    $service_data = mysqli_fetch_assoc($service);
    
    // Retrieve appointments based on the selected interval
    $interval = isset($_GET['interval']) ? $_GET['interval'] : null;
    $query = "SELECT * FROM `appointment_order` WHERE `service_id` = ?";
    $params = [$data['id']];

    if ($interval) {
        // Adjust query based on selected interval
        switch ($interval) {
            case 'daily':
                $query .= " AND DATE(`created_at`) = CURDATE()";
                break;
            case 'weekly':
                $query .= " AND WEEK(`created_at`) = WEEK(CURDATE())";
                break;
            case 'monthly':
                $query .= " AND MONTH(`created_at`) = MONTH(CURDATE())";
                break;
            case 'quarterly':
                $query .= " AND MONTH(`created_at`) >= MONTH(CURDATE()) - 3 AND MONTH(`created_at`) <= MONTH(CURDATE())";
                break;
            case 'yearly':
                $query .= " AND YEAR(`created_at`) = YEAR(CURDATE())";
                break;
        }
    }

    $appointment = select($query, $params, 'i');
    
    // Calculate total amount of appointments
    $totalAmount = 0;
    $Amount = 0;
    while($row = mysqli_fetch_assoc($appointment)) {
        $totalAmount += $row['trans_amt'];
        $Amount = number_format($totalAmount,2,'.',',');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PANEL - SERVICES</title>
    <?php require('includes/links.php');?>
    <style>
        .custom-alert{
            position: fixed;
            top: 80px;
            right: 25px;
        }
        .custom-bg{
            background-color: #A51012;
            border: 1px solid #A51012;
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
            <div class="text-end mb-4 d-flex justify-content-between align-items-center">
                <h4 class=""><?php echo $service_data['name'];?> Appointments History</h4>
                <a href="services.php" class="btn btn-secondary">BACK</a>
            </div>

            <div class="">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="">
                        <h4>Total Amount: ₱<?php echo $Amount; ?></h4>
                    </div>
                    <form id="filterForm" class="mb-2 col-6">
                        <label for="interval" class="form-label">Filter here:</label>
                        <div class="row">
                            <div class="col-md-9">
                                <select name="interval" id="interval" class="form-select">
                                    <option value="daily" <?php echo isset($_GET['interval']) && $_GET['interval'] === 'daily' ? 'selected' : ''; ?>>Daily</option>
                                    <option value="weekly" <?php echo isset($_GET['interval']) && $_GET['interval'] === 'weekly' ? 'selected' : ''; ?>>Weekly</option>
                                    <option value="monthly" <?php echo isset($_GET['interval']) && $_GET['interval'] === 'monthly' ? 'selected' : ''; ?>>Monthly</option>
                                    <option value="quarterly" <?php echo isset($_GET['interval']) && $_GET['interval'] === 'quarterly' ? 'selected' : ''; ?>>Quarterly</option>
                                    <option value="yearly" <?php echo isset($_GET['interval']) && $_GET['interval'] === 'yearly' ? 'selected' : ''; ?>>Yearly</option>
                                </select>
                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="filterButton" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
            
            <div class="card border-0 shadow-none mb-4">
                <div class="card-body">

                    <div class="row">
                    <?php
                        // Retrieve appointments based on the selected interval
                        $interval = isset($_GET['interval']) ? $_GET['interval'] : null;
                        $query = "SELECT * FROM `appointment_order` WHERE `service_id` = ?";
                        $params = [$data['id']];

                        if ($interval) {
                            // Adjust query based on selected interval
                            switch ($interval) {
                                case 'daily':
                                    $query .= " AND DATE(`created_at`) = CURDATE()";
                                    break;
                                case 'weekly':
                                    $query .= " AND WEEK(`created_at`) = WEEK(CURDATE())";
                                    break;
                                case 'monthly':
                                    $query .= " AND MONTH(`created_at`) = MONTH(CURDATE())";
                                    break;
                                case 'quarterly':
                                    $query .= " AND MONTH(`created_at`) >= MONTH(CURDATE()) - 3 AND MONTH(`created_at`) <= MONTH(CURDATE())";
                                    break;
                                case 'yearly':
                                    $query .= " AND YEAR(`created_at`) = YEAR(CURDATE())";
                                    break;
                            }
                        }

                        $appointment = select($query, $params, 'i');

                        
                        while($appointment_data = mysqli_fetch_assoc($appointment)){
                            $date = '';
                            if($appointment_data['date'] != null){
                                $date = date("F d, Y", strtotime($appointment_data['date']));
                            }
    
                            $price = $appointment_data['trans_amt'];
                            $formatedPrice = number_format($price,2,'.',',');
    
                            $patient = select("SELECT * FROM `patients` WHERE `id` = ?", [$appointment_data['patient_id']], 'i');
                            $patient_data = mysqli_fetch_assoc($patient);

                            echo<<<data
                                <div class="card p-3 mb-4 col-12">
                                    <div class="d-flex justify-content-between align-items-center"> 
                                        <h5 class="card-title ">Patient name: <span class="fw-light">$patient_data[first_name] $patient_data[last_name]</span></h5>
                                        <h6 class="card-subtitle ">$formatedPrice</h6>
                                    </div>
                                    <h6 class="card-subtitle ">Appointment date: <span class="fw-light">$date</span></h6>
                                </div>
                            data;
                        }
                    ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

    <?php require('includes/scripts.php');?>
    <script src="scripts/services.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#filterButton').click(function() {
                var formData = $('#filterForm').serialize();

                var currentUrl = window.location.href;

                var newUrl = currentUrl + '&' + formData;

                // Update the URL without reloading the page
                history.pushState(null, null, newUrl);

                // Reload the page to apply the filter (you can perform AJAX request instead)
                window.location.reload();
            });
        });
    </script>
</body>
</html>