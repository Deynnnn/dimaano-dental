<?php
header('Content-Type: application/json');

require ('../includes/dbConfig.php');
    require ('../includes/essentials.php');
    adminLogin() ;

$type = $_GET['type'];
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

$query = "SELECT * FROM appointment_order WHERE created_at BETWEEN ? AND ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$start_date, $end_date]);
$appointments = $stmt->fetchAll();

echo json_encode($appointments);
?>
