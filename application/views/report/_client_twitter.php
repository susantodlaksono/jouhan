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
foreach ($this->mapping_report->excelColumnRange('A', 'I') as $column) {
	$cell->getColumnDimension($column)->setAutoSize(true);
}
$cell->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:I1')->getFont()->setBold(TRUE);
$cell->getStyle('A1:I1')->applyFromArray(
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
$cell->setCellValue('E1', 'Screen Name');
$cell->setCellValue('F1', 'Password');
$cell->setCellValue('G1', 'Client');
$cell->setCellValue('H1', 'Proxy');
$cell->setCellValue('I1', 'Status');

$i = 3;
foreach ($report->result_array() as $v) {
	$cell->setCellValue('A'.$i, $v['first_name']);
	$cell->setCellValue('B'.$i, date('Y-m-d', strtotime($v['created_twitter'])));
	$cell->setCellValue('C'.$i, $v['phone_number']);
	$cell->setCellValue('D'.$i, $v['email']);
	$cell->setCellValue('E'.$i, $v['screen_name']);
	$cell->setCellValue('F'.$i, $v['password']);
	$cell->setCellValue('G'.$i, $v['client_name']);
	$cell->setCellValue('H'.$i, $v['proxy_name']);
	$cell->setCellValue('I'.$i, $v['status_name']);
	$i++;
}
// $cell->setAutoFilter('A2:I2');

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