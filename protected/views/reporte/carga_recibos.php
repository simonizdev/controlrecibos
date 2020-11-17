<h3>Carga de recibos</h3>

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'reporte-form',
  // Please note: When you enable ajax validation, make sure the corresponding
  // controller action is handling ajax validation correctly.
  // There is a call to performAjaxValidation() commented in generated controller code.
  // See class documentation of CActiveForm for details on this.
  'enableClientValidation'=>true,
  'clientOptions'=>array(
    'validateOnSubmit'=>true,
  ),
));

?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i>Realizado</h4>
      <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>  

<?php

echo $form->error($model,'recibos', array('class' => 'pull-right badge bg-red'));
echo $form->hiddenField($model,'recibos', array('class' => 'form-control', 'autocomplete' => 'off'));

$valid = 0;
$directorio = Yii::app()->params->directorio_recibos;

$arr_exts = array("JPEG","JPG","jpeg","jpg");

//si el directorio a recorrer es valido
if(file_exists($directorio)) {

  $directorio_escaneado = array_diff(scandir($directorio, 0), array('..', '.'));

  //si el directorio a recorrer no esta vacio
  if(!empty($directorio_escaneado)){

    $cadena = '<table class="table"><thead><tr><th>Recibo</th><th>Fecha de creación</th><th><input type="checkbox" id="select_all"/></th></tr></thead><tbody>';

    $cont = 0;

    $dir = opendir($directorio);
    while ($archivo = readdir($dir))
    {
        $info = new SplFileInfo($archivo);
        $ext=$info->getExtension();
        //si el archivo es valido
        if(($archivo !='.') && ($archivo !='..') && in_array($ext,$arr_exts))
        {
          //se valida si el archivo ya esta registrado en la bd para omitirlo
          $coe = strlen($ext);
          $ce = $coe + 1;
          $nombre = substr($archivo,0,-$ce); 

          $modelo_recibo = ControlRecibos::model()->findByAttributes(array('Recibo' => $nombre));

          if(empty($modelo_recibo)){

            $size = round(filesize($directorio.'/'.$archivo) / 1024, 0, PHP_ROUND_HALF_UP);
            
            if($size <= 512){

              $valid = 1;
              $stat = filectime($directorio.'/'.$archivo );
              $cadena .= '<tr><td>'.$nombre.'</td><td>'.UtilidadesVarias::textofechahora(date('Y-m-d H:i:s', $stat)).'</td><td><input type="checkbox" value="'.$archivo.'" class="checks"/></td></tr>';
              $cont++;

            }else{
              $stat = filectime($directorio.'/'.$archivo );
              $cadena .= '<tr><td>'.$nombre.'</td><td>'.UtilidadesVarias::textofechahora(date('Y-m-d H:i:s', $stat)).'</td><td>El archivo es demasiado grande Max. (512 KB / 0.5 MB)</td></tr>';
              $cont++; 
            }
          }
        }
    }

    $cadena .= '<tr><td colspan="3" align="right"><strong>'.$cont.' Recibo(s)</strong></td></tr></tbody></table>';

    echo $cadena;

    ?>
    
      <div class="btn-group" style="padding-bottom: 2%" id="btn_submit">
        <button type="button" class="btn btn-success" onclick="window.location.reload();"><i class="fa fa-refresh"></i> Actualizar vista</button>
        <?php if($valid == 1){ ?> 
          <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-upload"></i> Cargar / registrar recibos seleccionados</button>
        <?php } ?>
      </div>

    <?php

  }else{
    echo '<br>No hay recibos pendientes por cargar / registrar.<br><br><div class="row"><div class="col-sm-12"><div class="form-group"><input type="button" class="btn btn-success" value="Actualizar vista" onClick="window.location.reload();"></div></div></div>';
  }

}else{
  echo '<br>No se encontro la carpeta que aloja los recibos.<br><br><div class="row"><div class="col-sm-12"><div class="form-group"><input type="button" class="btn btn-success" value="Actualizar vista" onClick="window.location.reload();"></div></div></div>';
}

?>

<?php $this->endWidget(); ?>


<script>

$(function() {
  
  $('#select_all').change(function() {
      var checkboxes = $(this).closest('form').find('.checks');
      checkboxes.prop('checked', $(this).is(':checked'));
  });

  //se seleccionan todos los recibosd por defecto
  $("#select_all").click();


  $("#valida_form").click(function() {

      var form = $("#reporte-form");
      var settings = form.data('settings') ;
      settings.submitting = true ;

      var selected = '';    
      $('input:checkbox.checks').each(function(){
          if (this.checked) {
              selected += $(this).val()+',';
          }
      });

      var cadena = selected.slice(0,-1);
      $('#Reporte_recibos').val(cadena);

      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });

              //se envia el form
              $('#btn_submit').hide();
              form.submit();
              
          } else {

              settings = form.data('settings'),
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });

              settings.submitting = false ;
          }
      });
  });

});

</script>



