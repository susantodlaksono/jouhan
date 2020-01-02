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

$cell->setCellValue('A1', 'Fanspage Name');
$cell->setCellValue('B1', 'Fanspage URL');
$cell->setCellValue('C1', 'Facebook Admin ID');
$cell->setCellValue('D1', 'Followers');
$cell->setCellValue('E1', 'Likes');
$cell->setCellValue('F1', 'Client ID');
$cell->setCellValue('G1', 'Status ID');
$cell->setCellValue('H1', 'User ID');
$cell->setCellValue('I1', 'Info');
$cell->setCellValue('J1', 'Create Date (Format Y-m-d)');
$cell->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:J1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:J1')->getFont()->setBold(TRUE);
$cell->getStyle('A1:J1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
foreach(range('A','J1') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}
$cell->getStyle('A1:J1')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'ff0b0b')
    	)
	)
);

$cell->getSheetView()->setZoomScale(90);
$cell->setTitle('Format Migrasi');


//Master Data Sheet
$cell = $pe->createSheet();
$pe->setActiveSheetIndex(1);

foreach(range('A','N') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}




//Master Client
$cell->setCellValue('A1', 'Master Client ID');
$cell->setCellValue('A2', 'ID');
$cell->setCellValue('B2', 'Name');
$cell->mergeCells('A1:B1');

$cell->getStyle('A1:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:B2')->getFont()->setBold(TRUE);
$cell->getStyle('A1:B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$cell->getStyle('A1:B2')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'ff0b0b')
    	)
	)
);


$i = 3;
foreach ($client->result_array() as $v) {
	$cell->setCellValue('A'.$i, $v['id']);
	$cell->setCellValue('B'.$i, $v['name']);
	$i++;
}

//Master Proxy
$cell->setCellValue('D1', 'Facebook Admin ID');
$cell->setCellValue('D2', 'ID');
$cell->setCellValue('E2', 'URL');
$cell->setCellValue('F2', 'Display Name');
$cell->mergeCells('D1:F1');

$cell->getStyle('D1:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('D1:F2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('D1:F2')->getFont()->setBold(TRUE);
$cell->getStyle('D1:F2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$cell->getStyle('D1:F2')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'ff0b0b')
    	)
	)
);
foreach(range('D','F') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}

$i = 3;
foreach ($facebook->result_array() as $v) {
	$cell->setCellValue('D'.$i, $v['id']);
	$cell->setCellValue('E'.$i, $v['url'] ? $v['url'] : '');
	$cell->setCellValue('F'.$i, $v['display_name'] ? $v['display_name'] : '');
	$i++;
}

//Master Users 
$cell->setCellValue('H1', 'Master Users ID');
$cell->setCellValue('H2', 'ID');
$cell->setCellValue('I2', 'Username');
$cell->mergeCells('H1:I1');

$cell->getStyle('H1:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('H1:I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('H1:I2')->getFont()->setBold(TRUE);
$cell->getStyle('H1:I2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$cell->getStyle('H1:I2')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'ff0b0b')
    	)
	)
);
foreach(range('H','I') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}

$i = 3;
foreach ($users->result_array() as $v) {
	$cell->setCellValue('H'.$i, $v['id']);
	$cell->setCellValue('I'.$i, $v['username']);
	$i++;
}

//Master Status 
$cell->setCellValue('K1', 'Master Status ID');
$cell->setCellValue('K2', 'ID');
$cell->setCellValue('L2', 'Status');
$cell->mergeCells('K1:L1');

$cell->getStyle('K1:L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('K1:L2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('K1:L2')->getFont()->setBold(TRUE);
$cell->getStyle('K1:L2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$cell->getStyle('K1:L2')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'ff0b0b')
    	)
	)
);
foreach(range('K','L') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}

$i = 3;
foreach ($status as $k => $v) {
	$cell->setCellValue('K'.$i, $k);
	$cell->setCellValue('L'.$i, $v);
	$i++;
}

$cell->setTitle('Master Data');
$cell->getSheetView()->setZoomScale(90);

$filename = 'MigrationFanspage';
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
