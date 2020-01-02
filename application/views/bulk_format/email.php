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

$cell->setCellValue('A2', 'Phone Number Lama');
$cell->setCellValue('B2', 'Phone Number Baru');
$cell->setCellValue('C2', 'Email');
$cell->setCellValue('D2', 'Password');
$cell->setCellValue('E2', 'Status');

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

$cell->setCellValue('A1', 'Kosongkan Jika tidak ingin mengupdate Phone number Baru/Email/Password/Status');
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

$cell->setCellValue('A1', 'Master Status ID');
$cell->setCellValue('A2', 'ID');
$cell->setCellValue('B2', 'Status');
$cell->mergeCells('A1:B1');

$cell->getStyle('A1:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:B2')->getFont()->setBold(TRUE);
$cell->getStyle('A1:B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$cell->getStyle('A1:B2')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '404040')
    	)
	)
);

$i = 3;
foreach ($status as $k => $v) {
	$cell->setCellValue('A'.$i, $k);
	$cell->setCellValue('B'.$i, $v);
	$i++;
}

foreach(range('A','B') as $column_id) {
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