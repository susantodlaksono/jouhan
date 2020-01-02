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
//pilih sheet yang akan diisi (0 menandakan sheet pertama, index sheet dimulai dari 0,1,2 dst)
$phpexcel->setActiveSheetIndex(0);
//Tampung pada variabel, penamaan variabel bebas tidak harus $sheet, ini cuma variabel penampung phpexcel yg aktif saja
$sheet = $phpexcel->getActiveSheet();

//Isi Header
$sheet->setCellValue('A1', 'Phone Number');
$sheet->setCellValue('B1', 'Screen Name');
$sheet->setCellValue('C1', 'Display Name');

$i = 2; //Menampung hasil looping supaya hasil sesuai kolom

foreach ($twitter as $v) {
	$sheet->setCellValue('A'.$i, $v['phone_number']);	
	$sheet->setCellValue('B'.$i, $v['screen_name']);	
	$sheet->setCellValue('C'.$i, $v['display_name']);	
	$i++;
}

//Buat judul sheet yang aktif
$sheet->setTitle('Sheet 1');


//Footer terakhir, koding bawaan dari phpexcel ikuti saja
$fname = 'Contoh PHPEXCEL.xlsx';
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