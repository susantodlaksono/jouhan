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
$cell->setCellValue('B1', 'Display Name');
$cell->setCellValue('C1', 'Screen Name');
$cell->setCellValue('D1', 'Create Date (Example : 2019-01-31)');
$cell->setCellValue('E1', 'Password');
$cell->setCellValue('F1', 'Cookies');
$cell->setCellValue('G1', 'Twitter ID');
$cell->setCellValue('H1', 'Followers');
$cell->setCellValue('I1', 'Apps ID');
$cell->setCellValue('J1', 'Apps Name');
$cell->setCellValue('K1', 'Consumer Key');
$cell->setCellValue('L1', 'Consumer Secret');
$cell->setCellValue('M1', 'Access Token');
$cell->setCellValue('N1', 'Access Token Secret');
$cell->setCellValue('O1', 'Client ID');
$cell->setCellValue('P1', 'Proxy ID');
$cell->setCellValue('Q1', 'User ID');
$cell->setCellValue('R1', 'Status ID');
$cell->setCellValue('S1', 'Info');
$cell->getStyle('A1:S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('A1:S1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('A1:S1')->getFont()->setBold(TRUE);
foreach(range('A','S') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}
$cell->getStyle('A1:S1')->applyFromArray(
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
        'color' => array('rgb' => '404040')
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
$cell->setCellValue('D1', 'Master Proxy ID');
$cell->setCellValue('D2', 'ID');
$cell->setCellValue('E2', 'Network');
$cell->setCellValue('F2', 'IP Address');
$cell->setCellValue('G2', 'Port');
$cell->setCellValue('H2', 'Username');
$cell->setCellValue('I2', 'Password');
$cell->setCellValue('J2', 'Location');
$cell->setCellValue('K2', 'Status');
$cell->mergeCells('D1:K1');

$cell->getStyle('D1:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('D1:K2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('D1:K2')->getFont()->setBold(TRUE);
$cell->getStyle('D1:K2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$cell->getStyle('D1:K2')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '404040')
    	)
	)
);
foreach(range('D','K') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}

$i = 3;
foreach ($proxy->result_array() as $v) {
	$cell->setCellValue('D'.$i, $v['id']);
	$cell->setCellValue('E'.$i, $v['network'] == 1 ? 'VPS' : 'Proxy');
	$cell->setCellValue('F'.$i, $v['ip_address'] ? $v['ip_address'] : '');
	$cell->setCellValue('G'.$i, $v['port'] ? $v['port'] : '');
	$cell->setCellValue('H'.$i, $v['username'] ? $v['username'] : '');
	$cell->setCellValue('I'.$i, $v['password'] ? $v['password'] : '');
	$cell->setCellValue('J'.$i, $v['location'] ? $v['location'] : '');
	$cell->setCellValue('K'.$i, $v['status'] == 1 ? 'Connected' : 'Not Connected');
	$i++;
}

//Master Users 
$cell->setCellValue('M1', 'Master Users ID');
$cell->setCellValue('M2', 'ID');
$cell->setCellValue('N2', 'Username');
$cell->mergeCells('M1:N1');

$cell->getStyle('M1:N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('M1:N2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('M1:N2')->getFont()->setBold(TRUE);
$cell->getStyle('M1:N2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$cell->getStyle('M1:N2')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '404040')
    	)
	)
);
foreach(range('M','N') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}

$i = 3;
foreach ($users->result_array() as $v) {
	$cell->setCellValue('M'.$i, $v['id']);
	$cell->setCellValue('N'.$i, $v['username']);
	$i++;
}

//Master Status 
$cell->setCellValue('P1', 'Master Status ID');
$cell->setCellValue('P2', 'ID');
$cell->setCellValue('Q2', 'Status');
$cell->mergeCells('P1:Q1');

$cell->getStyle('P1:Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$cell->getStyle('P1:Q2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$cell->getStyle('P1:Q2')->getFont()->setBold(TRUE);
$cell->getStyle('P1:Q2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$cell->getStyle('P1:Q2')->applyFromArray(
	array(
    	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '404040')
    	)
	)
);
foreach(range('P','Q') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}

$i = 3;
foreach ($status->result_array() as $v) {
	$cell->setCellValue('P'.$i, $v['id']);
	$cell->setCellValue('Q'.$i, $v['name']);
	$i++;
}

$cell->setTitle('Master Data');

$filename = 'Format Migration Twitter';
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
