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
$cell->setCellValue('A1', 'Phone Number');
$cell->setCellValue('B1', 'Display Name');
$cell->setCellValue('C1', 'Screen Name');
$cell->setCellValue('D1', 'Create Date');
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
$cell->setCellValue('O1', 'Client');
$cell->setCellValue('P1', 'Proxy');
$cell->setCellValue('Q1', 'Created By');
$cell->setCellValue('R1', 'Status');
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
$i = 2;
if($report){
    foreach ($report as $key => $value) {
        $cell->setCellValue('A'.$i.'', $value['phone_number']);   
        $i++;
    }
}

$cell->setTitle('Raw Data Twitter');

$fname = $filename.'.xlsx';
$filepath = './download/'.$fname;
$writer = PHPExcel_IOFactory::createWriter($pe,'Excel2007');
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
