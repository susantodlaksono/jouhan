<?php

error_reporting(E_ALL);
ini_set('memory_limit', '1G');
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Jakarta');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Panggil library */
$this->load->library('PHPExcel');
$phpexcel = new PHPExcel();

// Buat sheet
$phpexcel->createSheet();
$phpexcel->setActiveSheetIndex(0);
$sheet = $phpexcel->getActiveSheet();

//Isi Header
$sheet->setCellValue('A1', 'Created By');
$sheet->setCellValue('B1', 'Created Date');
$sheet->setCellValue('C1', 'Fanspage URL');
$sheet->setCellValue('D1', 'Followers');
$sheet->setCellValue('E1', 'Likes');
$sheet->setCellValue('F1', 'Admin');
$sheet->setCellValue('G1', 'Client');
$sheet->setCellValue('H1', 'Info');
$sheet->setCellValue('I1', 'Status');

$i = 2; //Menampung hasil looping supaya hasil sesuai kolom

foreach ($result as $v) {
		
	$sheet->setCellValue('A'.$i, $v['userName']);	
	$sheet->setCellValue('B'.$i, $v['created_fanspage']);	
	$sheet->setCellValue('C'.$i, $v['fanspage_url']);	
	$sheet->setCellValue('D'.$i, $v['followers']);	
	$sheet->setCellValue('E'.$i, $v['likes']);	
	$sheet->setCellValue('F'.$i, $v['admin']);	
	$sheet->setCellValue('G'.$i, $v['clientName']);	
	$sheet->setCellValue('H'.$i, $v['info']);	
	$sheet->setCellValue('I'.$i, $v['status']);	
	$i++;
}

//Buat judul sheet yang aktif
$sheet->setTitle('Fanspage-Facebook');


//Footer terakhir, koding bawaan dari phpexcel ikuti saja
$fname = 'Data_Fanspage(FB).xlsx';
$writer = PHPExcel_IOFactory::createWriter($phpexcel,'Excel2007');
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