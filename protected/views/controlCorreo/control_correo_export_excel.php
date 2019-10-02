<?php
/* @var $this PromocionController */
/* @var $model Promocion */

//EXCEL

  // Se inactiva el autoloader de yii
  spl_autoload_unregister(array('YiiBase','autoload'));   

  require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';
  
  //cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
  spl_autoload_register(array('YiiBase','autoload'));

  $objPHPExcel = new PHPExcel();

  $objPHPExcel->getActiveSheet()->setTitle('Hoja1');
  $objPHPExcel->setActiveSheetIndex();

  /*Cabecera tabla*/

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'ID');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'ID Correo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Asunto de correo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Remitente de correo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Adjunto');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Fecha y hora de correo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Fecha y hora de registro');

  $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

  $Prom = "";
  $Fila= 3;

  /*Inicio contenido tabla*/

  foreach ($data as $reg) {

    $ID = $reg->ROWID;
    $ID_Correo = $reg->ID;
    $Asunto_correo  = $reg->ASUNTO;
    $Remitente_correo   = $reg->REMITENTE;
    $Adjunto = $reg->ANEXOS;
    $Fecha_hora_correo  = $reg->FECHA;
    $Fecha_hora_registro = $reg->REGISTRO;

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila,$ID);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila,$ID_Correo);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila,$Asunto_correo);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila,$Remitente_correo);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila,$Adjunto);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila,$Fecha_hora_correo);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila,$Fecha_hora_registro);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    $Fila ++;
         
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

  $n = 'Log_correo_control_recibos_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

?>

