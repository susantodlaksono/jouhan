<?php
set_time_limit(0);
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
// date_default_timezone_set('Asia/Jakarta');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

$this->load->library('PHPExcel');
$pe = new PHPExcel();

$pe->setActiveSheetIndex(0);
$cell = $pe->getActiveSheet();

##Style
foreach ($this->mapping_report->excelColumnRange('A', 'J') as $column) {
	$cell->getColumnDimension($column)->setAutoSize(true);
}
$cell->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:J1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:J1')->getFont()->setBold(TRUE);
$cell->getStyle('A1:J1')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'f2f2f2')
    	)
	)
);


$cell->setCellValue('A1', 'PIC');
$cell->setCellValue('B1', 'Created');
$cell->setCellValue('C1', 'Phone Number');
$cell->setCellValue('D1', 'Email');
$cell->setCellValue('E1', 'Display Name');
$cell->setCellValue('F1', 'Username');
$cell->setCellValue('G1', 'Password');
$cell->setCellValue('H1', 'Client');
$cell->setCellValue('I1', 'Proxy');
$cell->setCellValue('J1', 'Status');

$i = 3;
foreach ($report->result_array() as $v) {
	$cell->setCellValue('A'.$i, $v['first_name']);
	$cell->setCellValue('B'.$i, date('Y-m-d', strtotime($v['created_instagram'])));
	$cell->setCellValue('C'.$i, $v['phone_number']);
	$cell->setCellValue('D'.$i, $v['email']);
	$cell->setCellValue('E'.$i, $v['display_name']);
	$cell->setCellValue('F'.$i, $v['username']);
    $cell->setCellValue('G'.$i, $v['password']);
	$cell->setCellValue('H'.$i, $v['client_name']);
	$cell->setCellValue('I'.$i, $v['proxy_name']);
    switch ($v['status']) {
        case '1':
            $cell->setCellValue('J'.$i, 'Active');
            break;
        case '2':
            $cell->setCellValue('J'.$i, 'Blocked');
            break;
        default:
            $cell->setCellValue('J'.$i, '');       
            break;
    }
	$i++;
}
$cell->setAutoFilter('A2:J2');

$cell->setTitle('Raw Data');

$fname = $filename.'.xlsx';
$filepath = './download/'.$fname;
$writer = PHPExcel_IOFactory::createWriter($pe,'Excel2007');
$mode = isset($mode) ? $mode : 'download';

switch ($mode) {
 	case 'download':
     	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
     	header('Content-Disposition: attachment;filename="'.$fname.'"');
     	header('Cache-Control: max-age=0');
     	header('Cache-Control: max-age=1');
     	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
     	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
     	header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
     	header('Pragma: public'); // HTTP/1.0
     	$writer->save('php://output');
     	exit;
     	break;
 	case 'save':
     	$writer->save($filepath);
     	echo $filepath;
     	break;
}