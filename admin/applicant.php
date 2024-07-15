<?php
require('includes/essentials.php');
require('includes/dbConfig.php'); 

// Check if the user is logged in as an admin
adminLogin();

// Initialize an array to hold counts for each month
$monthlyCounts = array();

// Loop through each month of the year
for ($month = 1; $month <= 12; $month++) {
  // Get the first and last day of the month
  $firstDayOfMonth = date("Y-$month-01");
  $lastDayOfMonth = date("Y-m-t", strtotime($firstDayOfMonth));

  // Query to count applicants created within the current month
  $sql = "SELECT COUNT(*) AS count FROM appointment_order WHERE created_at BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth' service_id = ?";
  $result = $con->query($sql);

  if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    $monthlyCounts[] = $row['count'];
  } else {
    $monthlyCounts[] = 0;
  }
}

echo json_encode($monthlyCounts);

$con->close();
?>
