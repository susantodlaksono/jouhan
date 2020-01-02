<?php

error_reporting(E_ALL);
ini_set('memory_limit', '1G');
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Jakarta');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
$this->load->library('PHPExcel');
$phpexcel = new PHPExcel();

// Buat sheet
$phpexcel->setActiveSheetIndex(0);
$sheet = $phpexcel->getActiveSheet();


//Config and style
foreach ($this->mapping_report->excelColumnRange('A', 'Z') as $column) {
	$sheet->getColumnDimension($column)->setAutoSize(true);
}
$sheet->mergeCells('A1:F1');
$sheet->mergeCells('G1:I1');
$sheet->mergeCells('J1:O1');
$sheet->mergeCells('P1:U1');
$sheet->mergeCells('V1:Z1');
$sheet->getStyle('A1:Z1')->getFont()->setBold(TRUE);
$sheet->getStyle('A1:Z1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A1:Z1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$sheet->getStyle('A1:F2')->applyFromArray(
 	array(
     	'fill' => array(
         'type' => PHPExcel_Style_Fill::FILL_SOLID,
         'color' => array('rgb' => 'd9d9d9')
     	)
 	)
);
$sheet->getStyle('G1:I2')->applyFromArray(
 	array(
     	'fill' => array(
         'type' => PHPExcel_Style_Fill::FILL_SOLID,
         'color' => array('rgb' => 'ebf1de')
     	)
 	)
);
$sheet->getStyle('J1:O2')->applyFromArray(
 	array(
     	'fill' => array(
         'type' => PHPExcel_Style_Fill::FILL_SOLID,
         'color' => array('rgb' => 'b7dee8')
     	)
 	)
);
$sheet->getStyle('P1:U2')->applyFromArray(
 	array(
     	'fill' => array(
         'type' => PHPExcel_Style_Fill::FILL_SOLID,
         'color' => array('rgb' => 'b8cce4')
     	)
 	)
);
$sheet->getStyle('V1:Z2')->applyFromArray(
 	array(
     	'fill' => array(
         'type' => PHPExcel_Style_Fill::FILL_SOLID,
         'color' => array('rgb' => 'fabf8f')
     	)
 	)
);

//Isi Header
$sheet->setCellValue('A1', 'SIMCARD');
$sheet->setCellValue('A2', 'Phone Number');
$sheet->setCellValue('B2', 'Active Period');
$sheet->setCellValue('C2', 'Expired Date');
$sheet->setCellValue('D2', 'Saldo Simcard');
$sheet->setCellValue('E2', 'Rak Simcard');
$sheet->setCellValue('F2', 'Status Simcard');

$sheet->setCellValue('G1', 'EMAIL');
$sheet->setCellValue('G2', 'Email');
$sheet->setCellValue('H2', 'Password');
$sheet->setCellValue('I2', 'Status');

$sheet->setCellValue('J1', 'TWITTER');
$sheet->setCellValue('J2', 'PIC');
$sheet->setCellValue('K2', 'Screen Name');
$sheet->setCellValue('L2', 'Password');
$sheet->setCellValue('M2', 'Client');
$sheet->setCellValue('N2', 'Proxy');
$sheet->setCellValue('O2', 'Status');

$sheet->setCellValue('P1', 'FACEBOOK');
$sheet->setCellValue('P2', 'PIC');
$sheet->setCellValue('Q2', 'FB-ID');
$sheet->setCellValue('R2', 'Url');
$sheet->setCellValue('S2', 'Password');
$sheet->setCellValue('T2', 'Client');
$sheet->setCellValue('U2', 'Status');

$sheet->setCellValue('V1', 'INSTAGRAM');
$sheet->setCellValue('V2', 'PIC');
$sheet->setCellValue('W2', 'Username');
$sheet->setCellValue('X2', 'Password');
$sheet->setCellValue('Y2', 'Client');
$sheet->setCellValue('Z2', 'Status');

$i = 3;
 //Menampung hasil looping supaya hasil sesuai kolom
if($report){
   foreach ($report as $key) {
   	$sheet->getStyle('A'.$i)->getNumberFormat()->setFormatCode('0');
   	$sheet->setCellValue('A'.$i,$key['phone_number']);
   	$sheet->setCellValue('B'.$i,$key['active_period']);
   	$sheet->setCellValue('C'.$i,$key['expired_date']);
   	$sheet->setCellValue('D'.$i,$key['saldo']);
   	$sheet->setCellValue('E'.$i,$key['rak']);
   	$sheet->setCellValue('F'.$i,$key['status']);
   	$sheet->setCellValue('G'.$i,$key['email']);
   	$sheet->setCellValue('H'.$i,$key['b.password']);
   	$sheet->setCellValue('I'.$i,$key['b.status']);
   	$sheet->setCellValue('J'.$i,$key['c.username']);
   	$sheet->setCellValue('K'.$i,$key['c.screen_name']);
   	$sheet->setCellValue('L'.$i,$key['c.password']);
   	$sheet->setCellValue('M'.$i,$key['cl.name']);
   	$sheet->setCellValue('N'.$i,$key['proxy']);
   	$sheet->setCellValue('O'.$i,$key['c_detail.name']);
   	$sheet->setCellValue('P'.$i,$key['user_fb.username']);
   	$sheet->setCellValue('Q'.$i,$key['fb.id']);
   	$sheet->setCellValue('R'.$i,$key['fb.url']);
   	$sheet->setCellValue('S'.$i,$key['fb.password']);
   	$sheet->setCellValue('T'.$i,$key['clf.name']);
   	$sheet->setCellValue('U'.$i,$key['fb.status']);
   	$sheet->setCellValue('V'.$i,$key['user_ig.username']);
   	$sheet->setCellValue('W'.$i,$key['ig.username']);
   	$sheet->setCellValue('X'.$i,$key['ig.password']);
   	$sheet->setCellValue('Y'.$i,$key['cli.name']);
   	$sheet->setCellValue('Z'.$i,$key['ig.status']);
   	$i++;		
   }
}
$sheet->setTitle('All Module');

$fname = $filename.'.xlsx';
$filepath = './download/'.$fname;
$writer = PHPExcel_IOFactory::createWriter($phpexcel,'Excel2007');
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