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

$cell->setCellValue('A1', 'NO RAK');
$cell->setCellValue('B1', 'NAMA RAK');

$cell->getSheetView()->setZoomScale(90);
$cell->setTitle('Master RAK');

$filename = 'Format Master RAK';
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
