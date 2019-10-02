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
  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'ID Nota');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Cliente');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Nota');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Factura');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Vlr. factura');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', '% descuento');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Vlr. descuento');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Fecha Factura');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Fecha de pago');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Días de pago');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Recibo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Observaciones');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Respuesta');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Usuario que creo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Fecha de creación');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Usuario que actualizó');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Fecha de actualización');

  $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setBold(true);

  $Fila= 3;

  /*Inicio contenido tabla*/

  foreach ($data as $reg) {

    if($reg->Id_Control == ""){
      $id_nota = '';
    }else{
      $id_nota = $reg->Id_Control;
    }

    if($reg->Id_Cliente == ""){
      $cliente = '';
    }else{
      $cliente = $reg->Desc_Cliente($reg->Id_Cliente);
    }

    if($reg->Nota == ""){
      $nota = '';
    }else{
      $nota = $reg->Nota;
    }

    if($reg->Factura == ""){
      $factura = '';
    }else{
      $factura = $reg->Factura;
    }

    if($reg->Valor_Factura == ""){
      $vlr_factura = '';
    }else{
      $vlr_factura = $reg->Valor_Factura;
    }

    if($reg->Porc_Desc == ""){
      $porc_desc = '';
    }else{
      $porc_desc = $reg->Porc_Desc;
    }

    if($reg->Valor_Descuento == ""){
      $vlr_desc = '';
    }else{
      $vlr_desc = $reg->Valor_Descuento;
    }

    if($reg->Fecha_Factura == ""){
      $fecha_factura = '';
    }else{
      $fecha_factura = $reg->Fecha_Factura;
    }

    if($reg->Fecha_Pago == ""){
      $fecha_pago = '';
    }else{
      $fecha_pago = $reg->Fecha_Pago;
    }

    if($reg->Dias_Pago == ""){
      $dias_pago = '';
    }else{
      $dias_pago = $reg->Dias_Pago;
    }

    if($reg->Recibo == ""){
      $recibo = '';
    }else{
      $recibo = $reg->Recibo;
    }

    if($reg->Observaciones == ""){
      $observaciones = '';
    }else{
      $observaciones = $reg->Observaciones;
    }

    if($reg->Respuesta == ""){
      $respuesta = '';
    }else{
      switch ($reg->Respuesta) {
        case 0:
            $respuesta = 'EN ELAB.'; 
            break;
        case 1:
            $respuesta = 'APROBADO';  
            break;
        case 2:
            $respuesta = 'NO APROBADO'; 
            break;
      }
    }

    $usuario_creacion = $reg->idusuariocre->Usuario;
    $fecha_creacion = $reg->Fecha_Creacion;
    $usuario_actualizacion = $reg->idusuarioact->Usuario;
    $fecha_actualizacion = $reg->Fecha_Actualizacion;

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila,$id_nota);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila,$cliente);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila,$nota);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila,$factura);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila,$vlr_factura);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila,$porc_desc);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila,$vlr_desc);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila,$fecha_factura);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila,$fecha_pago);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila,$dias_pago);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila,$recibo);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila,$observaciones);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila,$respuesta);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila,$usuario_creacion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila,$fecha_creacion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila,$usuario_actualizacion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila,$fecha_actualizacion);

    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila)->getNumberFormat()->setFormatCode('0');

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

  $n = 'Control_notas_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

?>

