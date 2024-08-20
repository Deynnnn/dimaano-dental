<?php 

require('includes/essentials.php');
require('includes/dbConfig.php');
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

adminLogin();

if (!isset($_GET['id'])) {
    redirect('services.php');
}

$data = filteration($_GET);

$service = select("SELECT * FROM `services` WHERE `id` = ?", [$data['id']], 'i');
if (mysqli_num_rows($service) > 0) {
    $service_data = mysqli_fetch_assoc($service);
} else {
    // Handle the case where no service data is found
    die("Service data not found.");
}

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Dimaano Dental Clinic');
$pdf->SetTitle('Appointment Report');
$pdf->SetSubject('Appointments History');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Dimaano Dental Clinic', 'Appointment Service Report');

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Set title
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(0, 10, $service_data['name'] . ' Appointments Report', 0, 1, 'C');
$pdf->Ln(5);

// Set content font
$pdf->SetFont('helvetica', '', 12);

// Query the appointments based on the selected interval
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

$totalAmount = 0;
while ($row = mysqli_fetch_assoc($appointment)) {
    $totalAmount += $row['trans_amt'];
    $date = date("F d, Y", strtotime($row['created_at']));
    $price = number_format($row['trans_amt'], 2, '.', ',');

    // Fetch patient details
    $patient = select("SELECT * FROM `patients` WHERE `id` = ?", [$row['patient_id']], 'i');
    $patient_data = mysqli_fetch_assoc($patient);

    // Write each appointment to the PDF
    $pdf->Cell(0, 10, "Patient: {$patient_data['first_name']} {$patient_data['last_name']} - Appointment Date: $date - Amount: $price", 0, 1);
}

// Display total amount
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, "Total Amount: " . number_format($totalAmount, 2, '.', ','), 0, 1, 'R');

// Output PDF
$pdf->Output('appointment_report.pdf', 'I');

?>