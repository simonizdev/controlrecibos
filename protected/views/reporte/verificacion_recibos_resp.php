<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

//EXCEL

$query ="
  SET NOCOUNT ON
  EXEC [dbo].[CRC_CONS_RECIBOS]
";

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Número físico 1');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Ruta de recibo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Fecha de creación 1');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Usuario 1');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Número físico 2');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Recibo siesa');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Fecha de creación 2');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Fecha de aprobación');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Usuario 2');

$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    if($reg1 ['NUMERO_FISICO1'] == 0 ){
      $NUMERO_FISICO1 = ""; 
    }else{
      $NUMERO_FISICO1 = $reg1 ['NUMERO_FISICO1']; 
    } 

    $RUTA_RECIBO  = $reg1 ['RUTA_RECIBO'];

    if($reg1 ['FECHA_CREACION1'] == ""){
      $FECHA_CREACION1 = "";
    }else{
      $FECHA_CREACION1 = date("Y-m-d", strtotime($reg1 ['FECHA_CREACION1']));
    }

    $USUARIO1  = $reg1 ['USUARIO1'];
    
    if($reg1 ['NUMERO_FISICO2'] == 0 ){
      $NUMERO_FISICO2 = ""; 
    }else{
      $NUMERO_FISICO2 = $reg1 ['NUMERO_FISICO2']; 
    } 

    $RECIBO_SIESA  = $reg1 ['RECIBO_SIESA'];

    if($reg1 ['FECHA_CREACION2'] == ""){
      $FECHA_CREACION2 = "";
    }else{
      $FECHA_CREACION2 = date("Y-m-d", strtotime($reg1 ['FECHA_CREACION2']));
    }

    if($reg1 ['FECHA_APROBACION'] == ""){
      $FECHA_APROBACION = "";
    }else{
      $FECHA_APROBACION = date("Y-m-d", strtotime($reg1 ['FECHA_APROBACION']));
    }

    $USUARIO2  = $reg1 ['USUARIO2'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $NUMERO_FISICO1);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $RUTA_RECIBO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $FECHA_CREACION1);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $USUARIO1);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $NUMERO_FISICO2);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $RECIBO_SIESA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $FECHA_CREACION2);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $FECHA_APROBACION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $USUARIO2);
        
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    
    $Fila = $Fila + 1; 
      
  }
}

/*fin contenido tabla*/

//se configura el ancho de cada columna en automatico solo funciona en el rango A-Z
foreach($objPHPExcel->getWorksheetIterator() as $worksheet) {

    $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));

    $sheet = $objPHPExcel->getActiveSheet();
    $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(true);
    foreach ($cellIterator as $cell) {
        $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
    }
}

$n = 'Consulta_verificacion_recibos_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>











