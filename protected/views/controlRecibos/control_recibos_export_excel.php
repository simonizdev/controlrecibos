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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Recibo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Estado');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Estado de verificación');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Fecha banco');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Banco correcto');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Motivo de rechazo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Usuario que cargo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Fecha y hora de carga');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Usuario que verificó');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Fecha y hora de verificación');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Usuario que aplicó');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Fecha y hora de aplicación');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Usuario que verifica ent. física');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Fecha y hora de verificación ent. física  ');


  $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);

  $Prom = "";
  $Fila= 3;

  /*Inicio contenido tabla*/

  foreach ($data as $reg) {

    $recibo = $reg->Recibo;
    $estado = $reg->Desc_Opc($reg->Opc);
    $estado_ver = ($reg->Verificacion == "") ? "NO ASIGNADO" : $reg->Desc_Verif($reg->Verificacion);
    $fecha_banco = ($reg->Fecha_Banco == "") ? "N/A" : $reg->Fecha_Banco;
    $banco_correcto = ($reg->Banco_Correcto == "") ? "NO ASIGNADO" : $reg->Desc_Banco($reg->Banco_Correcto);
    $motivo_rechazo = ($reg->Motivo_Rechazo == "") ? "NO ASIGNADO" : $reg->Desc_Motivo_Rechazo($reg->Motivo_Rechazo);
    $usuario_carga = $reg->idusuariocarga->Usuario;
    $fecha_hora_carga = $reg->Fecha_Hora_Carga;
    $usuario_verificacion = ($reg->Id_Usuario_Verif == "") ? "NO ASIGNADO" : $reg->idusuarioverif->Usuario;
    $fecha_hora_verificacion = ($reg->Fecha_Hora_Verif == "") ? "NO ASIGNADO" : $reg->Fecha_Hora_Verif;
    $usuario_aplicacion = ($reg->Id_Usuario_Aplic == "") ? "NO ASIGNADO" : $reg->idusuarioaplic->Usuario;
    $fecha_hora_aplicacion = ($reg->Fecha_Hora_Aplic == "") ? "NO ASIGNADO" : $reg->Fecha_Hora_Aplic;
    $usuario_entrega_fis = ($reg->Id_Usuario_Rec_Fis == "") ? "NO ASIGNADO" : $reg->idusuariorecfis->Usuario;
    $fecha_hora_entrega_fis = ($reg->Fecha_Hora_Rec_Fis == "") ? "NO ASIGNADO" : $reg->Fecha_Hora_Rec_Fis;


    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila,$recibo);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila,$estado);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila,$estado_ver);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila,$fecha_banco);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila,$banco_correcto);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila,$motivo_rechazo);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila,$usuario_carga);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila,$fecha_hora_carga);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila,$usuario_verificacion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila,$fecha_hora_verificacion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila,$usuario_aplicacion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila,$fecha_hora_aplicacion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila,$usuario_entrega_fis);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila,$fecha_hora_entrega_fis);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':N'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

  $n = 'Estado_recibos_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

?>

