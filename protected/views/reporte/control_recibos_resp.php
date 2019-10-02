<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte
$fecha_inicial = $model['fecha_inicial'];
$fecha_final = $model['fecha_final'];

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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Fecha');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'N°. recibos cargados');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'N°. recibos verificados');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'N°. recibos aplicados');

$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);

$Fila = 2;

$f_inicial = new DateTime($fecha_inicial);
$f_final = new DateTime($fecha_final);
$diff = $f_inicial->diff($f_final);

$diff_days = $diff->days + 1;

$total_rc = 0;
$total_rv = 0;
$total_ra = 0;

$tabla = '
<table class="table table-striped table-hover">
        <thead>
          <tr>
          <th>Fecha</th>
          <th>N°. recibos cargados</th>
          <th>N°. recibos verificados</th>
          <th>N°. recibos aplicados</th>
          </tr>
        </thead>
    <tbody>';


for ($i=0; $i < $diff_days; $i++) { 
  $fecha = date($fecha_inicial);
  $nueva_fecha = strtotime('+'.$i.' day' , strtotime ($fecha)) ;
  $nueva_fecha = date ( 'Y-m-d' , $nueva_fecha);

  $r_i = $nueva_fecha.' 00:00:00';
  $r_f = $nueva_fecha.' 23:59:59';

  //recibos cargados
  $rc = Yii::app()->db->createCommand("SELECT COUNT(Id_Control) AS Rec_Carg FROM TH_CONTROL_RECIBOS WHERE Fecha_Hora_Carga BETWEEN '$r_i' AND '$r_f'")->queryRow();
  $recibos_cargados = $rc['Rec_Carg'];

  $total_rc = $total_rc + $recibos_cargados; 

  //recibos verificados
  $rv = Yii::app()->db->createCommand("SELECT COUNT(Id_Control) AS Rec_Verif FROM TH_CONTROL_RECIBOS WHERE Fecha_Hora_Verif BETWEEN '$r_i' AND '$r_f'")->queryRow();
  $recibos_verificados = $rv['Rec_Verif'];

  $total_rv = $total_rv + $recibos_verificados; 

  //recibos aplicados
  $rv = Yii::app()->db->createCommand("SELECT COUNT(Id_Control) AS Rec_Aplic FROM TH_CONTROL_RECIBOS WHERE Fecha_Hora_Aplic BETWEEN '$r_i' AND '$r_f'")->queryRow();
  $recibos_aplicados = $rv['Rec_Aplic'];

  $total_ra = $total_ra + $recibos_aplicados; 

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, UtilidadesVarias::textofecha($nueva_fecha));
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $recibos_cargados);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $recibos_verificados);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $recibos_aplicados);
      
  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  
  $Fila = $Fila + 1; 


}

$objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, 'TOTAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $recibos_cargados);
$objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $recibos_verificados);
$objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $recibos_aplicados);

$objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':D'.$Fila)->getFont()->setBold(true);

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

$n = 'Consulta_control_recibos_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>











