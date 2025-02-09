<?php
require '../config/database.php';
require '../vendor/autoload.php'; // Ensure PhpSpreadsheet is installed via Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$filter = $_GET['filter'] ?? 'today';
$filename = "sessions_"; // Base file name

// Determine date filter condition and filename
switch ($filter) {
    case 'yesterday':
        $dateCondition = "DATE(s.check_in_time) = CURDATE() - INTERVAL 1 DAY";
        $dateRange = "Yesterday (" . date('Y-m-d', strtotime('-1 day')) . ")";
        $filename .= "yesterday.xlsx";
        break;
    case 'last7days':
        $dateCondition = "s.check_in_time >= NOW() - INTERVAL 7 DAY";
        $dateRange = "Last 7 Days (" . date('Y-m-d', strtotime('-7 days')) . " to " . date('Y-m-d') . ")";
        $filename .= "last_7_days.xlsx";
        break;
    case 'thismonth':
        $dateCondition = "MONTH(s.check_in_time) = MONTH(CURDATE()) AND YEAR(s.check_in_time) = YEAR(CURDATE())";
        $dateRange = "This Month (" . date('F Y') . ")";
        $filename .= "this_month.xlsx";
        break;
    case 'lastmonth':
        $dateCondition = "MONTH(s.check_in_time) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND YEAR(s.check_in_time) = YEAR(CURDATE())";
        $dateRange = "Last Month (" . date('F Y', strtotime('-1 month')) . ")";
        $filename .= "last_month.xlsx";
        break;
    case 'last6months':
        $dateCondition = "s.check_in_time >= NOW() - INTERVAL 6 MONTH";
        $dateRange = "Last 6 Months (" . date('Y-m-d', strtotime('-6 months')) . " to " . date('Y-m-d') . ")";
        $filename .= "last_6_months.xlsx";
        break;
    case 'lastyear':
        $dateCondition = "YEAR(s.check_in_time) = YEAR(CURDATE()) - 1";
        $dateRange = "Last Year (" . date('Y', strtotime('-1 year')) . ")";
        $filename .= "last_year.xlsx";
        break;
    case 'today':
    default:
        $dateCondition = "DATE(s.check_in_time) = CURDATE()";
        $dateRange = "Today (" . date('Y-m-d') . ")";
        $filename .= "today.xlsx";
        break;
}

// Fetch session data
$query = "SELECT k.name, k.contact, s.check_in_time, s.check_out_time, s.assigned_hours 
          FROM sessions s
          JOIN kids k ON s.kid_id = k.id
          WHERE s.check_out_time IS NOT NULL AND $dateCondition
          ORDER BY s.check_out_time DESC";

$result = $db->query($query);

// Create Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set Title
$sheet->setCellValue('A1', "Checkout Sessions Report");
$sheet->setCellValue('A2', "Date Range: $dateRange");

// Apply Bold Formatting
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A2')->getFont()->setBold(true);

// Set Headers (Start from Row 4)
$headers = ['A' => 'Kid Name', 'B' => 'Contact', 'C' => 'Check-In Time', 'D' => 'Check-Out Time', 'E' => 'Assigned Hours'];
foreach ($headers as $column => $header) {
    $sheet->setCellValue("{$column}4", $header);
    $sheet->getStyle("{$column}4")->getFont()->setBold(true);
}

// Populate Data (Start from Row 5)
$row = 5;
while ($data = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $data['name']);
    $sheet->setCellValue('B' . $row, $data['contact']);
    $sheet->setCellValue('C' . $row, $data['check_in_time']);
    $sheet->setCellValue('D' . $row, $data['check_out_time']);
    $sheet->setCellValue('E' . $row, $data['assigned_hours']);
    $row++;
}

// Auto-adjust column width
foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Set Headers for Download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
