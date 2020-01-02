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
$cell->setCellValue('B2', 'Client ID');
$cell->setCellValue('C2', 'Status ID');
$cell->setCellValue('D2', 'Proxy ID');
$cell->setCellValue('E2', 'Password');

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

$cell->getColumnDimension('A')->setWidth(35);

$cell->setCellValue('A1', 'Kosongkan Jika tidak ingin mengupdate Client ID/Status ID/Proxy ID/Password');
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

//CLient ID
$cell->setCellValue('A1', 'Master Rak ID');
$cell->setCellValue('A2', 'ID');
$cell->setCellValue('B2', 'Nama Client');
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

foreach(range('A','B') as $column_id) {
 	$cell->getColumnDimension($column_id)->setAutoSize(true);
}

//Proxy ID
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

foreach(range('D','K') as $column_id) {
    $cell->getColumnDimension($column_id)->setAutoSize(true);
}

//Status ID
$cell->setCellValue('M1', 'Master Status ID');
$cell->setCellValue('M2', 'ID');
$cell->setCellValue('N2', 'Status');
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

$i = 3;
foreach ($status as $key => $v) {
    $cell->setCellValue('M'.$i, $key);
    $cell->setCellValue('N'.$i, $v);
    $i++;
}

foreach(range('M','N') as $column_id) {
    $cell->getColumnDimension($column_id)->setAutoSize(true);
}

$cell->freezePane('A3');
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