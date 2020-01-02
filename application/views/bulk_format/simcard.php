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

$cell->setCellValue('A2', 'Phone Number');
$cell->setCellValue('B2', 'Active Period (tahun-bulan-tgl)');
$cell->setCellValue('C2', 'Saldo');
$cell->setCellValue('D2', 'Rak ID');
$cell->setCellValue('E2', 'Status ID');

//kode aktivasi untuk format
$cell->setCellValue('ZZ3', '1');

$cell->getStyle('A1:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:E2')->getFont()->setBold(TRUE);
$cell->getStyle('A2:E2')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'f2f2f2')
    	)
	)
);
foreach(range('A','E') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}

$cell->setCellValue('A1', 'Kosongkan Jika tidak ingin mengupdate Active Period/Saldo/Rak ID');
$cell->mergeCells('A1:E1');
$cell->getStyle('A1:E1')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'ff0000')
    	)
	)
);
$cell->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$cell->freezePane('F3');
$cell->setTitle('List Phone Number');

// Sheet Master
$pe->createSheet();
$pe->setActiveSheetIndex(1);
$cell = $pe->getActiveSheet();

$cell->setCellValue('A1', 'Master Rak ID');
$cell->setCellValue('A2', 'ID');
$cell->setCellValue('B2', 'No Rak');
$cell->setCellValue('C2', 'Nama Rak');
$cell->mergeCells('A1:C1');

$cell->getStyle('A1:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:C2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:C2')->getFont()->setBold(TRUE);
$cell->getStyle('A1:C2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$cell->getStyle('A1:C2')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '404040')
    	)
	)
);

$i = 3;
foreach ($rak->result_array() as $v) {
	$cell->setCellValue('A'.$i, $v['id']);
	$cell->setCellValue('B'.$i, $v['no']);
	$cell->setCellValue('C'.$i, $v['nama_rak']);
	$i++;
}

foreach(range('A','C') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}

$cell->setCellValue('E1', 'Master Status ID');
$cell->setCellValue('E2', 'ID');
$cell->setCellValue('F2', 'Status');
$cell->mergeCells('E1:F1');

$cell->getStyle('E1:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('E1:F2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('E1:F2')->getFont()->setBold(TRUE);
$cell->getStyle('E1:F2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$cell->getStyle('E1:F2')->applyFromArray(
    array(
        'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '404040')
        )
    )
);

$i = 3;
foreach ($status as $k => $v) {
    $cell->setCellValue('E'.$i, $k);
    $cell->setCellValue('F'.$i, $v);
    $i++;
}

foreach(range('E','F') as $column_id) {
    $cell->getColumnDimension($column_id)->setAutoSize(true);
}

$cell->freezePane('G3');
$cell->setTitle('Master Data');


$filename = 'PhoneNumberList';
$writer = PHPExcel_IOFactory::createWriter($pe, 'Excel2007');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$writer->save('php://output');
exit;