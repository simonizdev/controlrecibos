<?php
/* @var $this ControlNotasController */
/* @var $model ControlNotas */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'control-notas-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>


<div class="row">
  <div class="col-sm-6">
    <div class="form-group">
      <?php echo $form->error($model,'Id_Cliente', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'Id_Cliente'); ?>
      <?php echo $form->textField($model,'Id_Cliente'); ?>
      <?php
      $this->widget('ext.select2.ESelect2', array(
          'selector' => '#ControlNotas_Id_Cliente',

          'options'  => array(
            'allowClear' => true,
            'minimumInputLength' => 5,
                'width' => '100%',
                'language' => 'es',
                'ajax' => array(
                      'url' => Yii::app()->createUrl('controlNotas/SearchCliente'),
                  'dataType'=>'json',
                    'data'=>'js:function(term){return{q: term};}',
                    'results'=>'js:function(data){ return {results:data};}'
                             
              ),
              'formatNoMatches'=> 'js:function(){ clear_select2_ajax("ControlNotas_Id_Cliente"); return "No se encontraron resultados"; }',
              'formatInputTooShort' =>  'js:function(){ return "Digite más de 5 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'ControlNotas_Id_Cliente\')\">Limpiar campo</button>"; }',
              'initSelection'=>'js:function(element,callback) {
                 	var id=$(element).val(); // read #selector value
                 	if ( id !== "" ) {
                   	$.ajax("'.Yii::app()->createUrl('controlNotas/SearchClienteById').'", {
                     		data: { id: id },
                     		dataType: "json"
                   	}).done(function(data,textStatus, jqXHR) { callback(data[0]); });
                 }
              }',
          ),

        ));
      ?>
    </div>
  </div>
  <div class="col-sm-3">
  	<div class="form-group">
			<?php echo $form->error($model,'Nota', array('class' => 'pull-right badge bg-red')); ?>
			<?php echo $form->label($model,'Nota'); ?>
	    <?php echo $form->textField($model,'Nota', array('class' => 'form-control', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
  	</div>
  </div>
  <div class="col-sm-3">
  	<div class="form-group">
			<?php echo $form->error($model,'Factura', array('class' => 'pull-right badge bg-red')); ?>
			<?php echo $form->label($model,'Factura'); ?>
	    <?php echo $form->textField($model,'Factura', array('class' => 'form-control', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
  	</div>
  </div>
</div>

<div class="row">
	<div class="col-sm-4">
  	<div class="form-group">
			<?php echo $form->error($model,'Valor_Factura', array('class' => 'pull-right badge bg-red')); ?>
			<?php echo $form->label($model,'Valor_Factura'); ?>
	    <?php echo $form->numberField($model,'Valor_Factura', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
  	</div>
  </div>	
  <div class="col-sm-4">
  	<div class="form-group">
			<?php echo $form->error($model,'Porc_Desc', array('class' => 'pull-right badge bg-red')); ?>
			<?php echo $form->label($model,'Porc_Desc'); ?>
	    <?php echo $form->numberField($model,'Porc_Desc', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'step' => '0.01' )); ?>
  	</div>
  </div>
  <div class="col-sm-4">
  	<div class="form-group">
			<?php echo $form->error($model,'Valor_Descuento', array('class' => 'pull-right badge bg-red')); ?>
			<?php echo $form->label($model,'Valor_Descuento'); ?>
	    <?php echo $form->numberField($model,'Valor_Descuento', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'readonly' => true)); ?>
  	</div>
  </div>
</div>


<div class="row">
	<div class="col-sm-4">
  	<div class="form-group">
  		<?php echo $form->error($model,'Fecha_Factura', array('class' => 'pull-right badge bg-red')); ?>
    	<?php echo $form->label($model,'Fecha_Factura'); ?>
	    <?php echo $form->textField($model,'Fecha_Factura', array('class' => 'form-control', 'readonly' => true)); ?>
    </div>
  </div>
  <div class="col-sm-4">
  	<div class="form-group">
			<?php echo $form->error($model,'Fecha_Pago', array('class' => 'pull-right badge bg-red')); ?>
	  	<?php echo $form->label($model,'Fecha_Pago'); ?>
	    <?php echo $form->textField($model,'Fecha_Pago', array('class' => 'form-control', 'readonly' => true)); ?>
    </div>
  </div>
  <div class="col-sm-4">
  	<div class="form-group">
			<?php echo $form->error($model,'Dias_Pago', array('class' => 'pull-right badge bg-red')); ?>
			<?php echo $form->label($model,'Dias_Pago'); ?>
	    <?php echo $form->numberField($model,'Dias_Pago', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'readonly' => true)); ?>
  	</div>
  </div>
</div>


<div class="row">
  <div class="col-sm-4">
    <div class="form-group">
      <?php echo $form->error($model,'Recibo', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'Recibo'); ?>
      <?php echo $form->textField($model,'Recibo', array('class' => 'form-control', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
    </div>
  </div>
  <div class="col-sm-4">
		<div class="form-group">
			<?php echo $form->error($model,'Observaciones', array('class' => 'pull-right badge bg-red')); ?>
			<?php echo $form->label($model,'Observaciones'); ?>
			<?php echo $form->textArea($model,'Observaciones',array('class' => 'form-control', 'rows'=>6, 'cols'=>50, 'onkeyup' => 'convert_may(this)')); ?>
		</div>
	</div>
  <?php if($model->isNewRecord){ ?>
    <div class="col-sm-4">
      <div class="form-group">
        <?php echo $form->hiddenField($model,'Respuesta', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'value' => 0)); ?>
      </div>
    </div>
  <?php }else{ ?>
    <div class="col-sm-4">
      <div class="form-group">
        <?php echo $form->error($model,'Respuesta', array('class' => 'pull-right badge bg-red')); ?>
        <?php echo $form->label($model,'Respuesta'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
                'name'=>'ControlNotas[Respuesta]',
                'id'=>'ControlNotas_Respuesta',
                'data'=>array(0 => "EN ELAB.", 1 => "APROBADO", 2 => "NO APROBADO"),
                'value' => $model->Respuesta,
                'htmlOptions'=>array(),
                'options'=>array(
                    'placeholder'=>'Seleccione...',
                    'width'=> '100%',
                    'allowClear'=>true,
                ),
            ));
        ?>
      </div>
    </div>
  <?php } ?>
</div>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=controlNotas/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="submit" class="btn btn-success" ><i class="fa fa-floppy-o"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
</div>

<?php $this->endWidget(); ?>

<script>

$(function() {

  $("#valida_form").click(function() {

    var form = $("#reporte-form");
    var settings = form.data('settings') ;
    settings.submitting = true ;

    $.fn.yiiactiveform.validate(form, function(messages) {
        if($.isEmptyObject(messages)) {
            $.each(settings.attributes, function () {
               $.fn.yiiactiveform.updateInput(this,messages,form); 
            });
            //se envia el form
            form.submit();
            $(".ajax-loader").fadeIn('fast');
            setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 20000);
        } else {

            settings = form.data('settings'),
            $.each(settings.attributes, function () {
              $.fn.yiiactiveform.updateInput(this,messages,form); 
            });

            settings.submitting = false ;
        }
    });
  });

	$("#ControlNotas_Fecha_Factura").change(function() {
		var f_factura = this.value;
		var f_pago =  $("#ControlNotas_Fecha_Pago").val();

		if(f_factura != "" && f_pago != ""){
			var fecha_factura = moment(f_factura);
			var fecha_pago = moment(f_pago);
			$("#ControlNotas_Dias_Pago").val(fecha_pago.diff(fecha_factura, 'days'));
		}else{
			$("#ControlNotas_Dias_Pago").val('');
		}
		
  });

  $("#ControlNotas_Fecha_Pago").change(function() {
   	f_factura =  $("#ControlNotas_Fecha_Factura").val();
   	f_pago = this.value;

   	if(f_factura != "" && f_pago != ""){
			var fecha_factura = moment(f_factura);
			var fecha_pago = moment(f_pago);

			$("#ControlNotas_Dias_Pago").val(fecha_pago.diff(fecha_factura, 'days'));
		}else{
			$("#ControlNotas_Dias_Pago").val('');
		}

  });

  $("#ControlNotas_Valor_Factura").change(function() {
 		var vlr_factura = this.value;
 		var porc_desc = $("#ControlNotas_Porc_Desc").val();

 		if(vlr_factura != "" && porc_desc != ""){
 			var porc_desc = ($("#ControlNotas_Porc_Desc").val()) / 100;

			var vlr_descuento = (vlr_factura / 1.19) * porc_desc;
			$("#ControlNotas_Valor_Descuento").val(Math.round(vlr_descuento));
		}else{
			$("#ControlNotas_Valor_Descuento").val('');
		}		

  });

  $("#ControlNotas_Porc_Desc").change(function() {
   	var vlr_factura = $("#ControlNotas_Valor_Factura").val();
   	var porc_desc = (this.value);

   	if(vlr_factura != "" && porc_desc != ""){
   		var porc_desc = (this.value) / 100;

   		var vlr_descuento = (vlr_factura / 1.19) * porc_desc;
			$("#ControlNotas_Valor_Descuento").val(Math.round(vlr_descuento));
		}else{
			$("#ControlNotas_Valor_Descuento").val('');
		}

  });

  //variables para el lenguaje del datepicker
  $.fn.datepicker.dates['es'] = {
      days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
      daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
      daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
      months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
      monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
      today: "Hoy",
      clear: "Limpiar",
      format: "yyyy-mm-dd",
      titleFormat: "MM yyyy",
      weekStart: 1
  };

  $("#ControlNotas_Fecha_Factura").datepicker({
      language: 'es',
      autoclose: true,
      orientation: "right bottom",
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#ControlNotas_Fecha_Pago').datepicker('setStartDate', minDate);
  });

  $("#ControlNotas_Fecha_Pago").datepicker({
      language: 'es',
      autoclose: true,
      orientation: "right bottom",
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#ControlNotas_Fecha_Factura').datepicker('setEndDate', maxDate);
  });
  
});

function clear_select2_ajax(id){
  $('#'+id+'').val('').trigger('change');
  $('#s2id_'+id+' span').html("");
}

</script>

