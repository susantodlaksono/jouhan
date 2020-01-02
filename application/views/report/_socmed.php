<?php

error_reporting(E_ALL);
ini_set('memory_limit', '1G');
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Jakarta');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
$this->load->library('PHPExcel');
$phpexcel = new PHPExcel();
    
$alphabet = range('A', 'Z');
$i = 0;

if($report){
    foreach ($report as $key => $value) {
        $totalfield = (count($module[$key]) - 1);
        if ($i > 0) {
            $phpexcel->createSheet();
        }
        $phpexcel->setActiveSheetIndex($i);
        $sheet = $phpexcel->getActiveSheet();

        foreach ($module[$key] as $k => $v) {
            $sheet->setCellValue(''.$alphabet[$k].'1', $field_master[$key][$v]);   
            $sheet->getColumnDimension(''.$alphabet[$k].'')->setWidth(20); 

            $sheet->getStyle('A1:'.$alphabet[$totalfield].'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle('A1:'.$alphabet[$totalfield].'1')->getFill()->getStartColor()->setARGB('f2f2f2');
            $sheet->getStyle('A1:'.$alphabet[$totalfield].'1')->getFont()->setBold(TRUE);

            $sheet->getStyle('A1:'.$alphabet[$totalfield].'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:'.$alphabet[$totalfield].'1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }

        $column = 2;
        foreach ($value as $k => $v) {
            $column++;
            foreach ($module[$key] as $kk => $vv) {
                $sheet->setCellValue(''.$alphabet[$kk].''.$column.'', $v[$vv]);
            }
        }

        $sheet->setTitle($key);
        $i++;
    }
}
$fname = $filename.'.xlsx';
$filepath = './download/'.$fname;
$writer = PHPExcel_IOFactory::createWriter($phpexcel,'Excel2007');
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