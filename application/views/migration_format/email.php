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

$cell->freezePane('A2');
$cell->setCellValue('ZZ3', 1);
$cell->setCellValue('A1', 'Phone Number');
$cell->setCellValue('B1', 'Email');
$cell->setCellValue('C1', 'Password');
$cell->setCellValue('D1', 'Birth Date (Example : 2019-01-31)');
$cell->setCellValue('E1', 'Display Name');
$cell->setCellValue('F1', 'User ID');
$cell->setCellValue('G1', 'Status ID');
$cell->setCellValue('H1', 'Info');
$cell->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:H1')->getFont()->setBold(TRUE);
foreach(range('A','H') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}
$cell->getStyle('A1:H1')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'f2f2f2')
    	)
	)
);

$cell->setTitle('Format Migrasi');


//Master Data Sheet
$cell = $pe->createSheet();
$pe->setActiveSheetIndex(1);
$cell->freezePane('A3');

//Master Users 
$cell->setCellValue('A1', 'Master Users ID');
$cell->setCellValue('A2', 'ID');
$cell->setCellValue('B2', 'Username');
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
foreach(range('A','B') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}

$i = 3;
foreach ($users->result_array() as $v) {
	$cell->setCellValue('A'.$i, $v['id']);
	$cell->setCellValue('B'.$i, $v['username']);
	$i++;
}

//Master Status 
$cell->setCellValue('D1', 'Master Status ID');
$cell->setCellValue('D2', 'ID');
$cell->setCellValue('E2', 'Status');
$cell->mergeCells('D1:E1');

$cell->getStyle('D1:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('D1:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('D1:E2')->getFont()->setBold(TRUE);
$cell->getStyle('D1:E2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$cell->getStyle('D1:E2')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '404040')
    	)
	)
);
foreach(range('D','E') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}

$i = 3;
foreach ($status as $k => $v) {
	$cell->setCellValue('D'.$i, $k);
	$cell->setCellValue('E'.$i, $v);
	$i++;
}

$cell->setTitle('Master Data');

$filename = 'Format Migration Email';
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
