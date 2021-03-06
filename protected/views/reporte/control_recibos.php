<?php
/* @var $this InventarioController */
/* @var $model Inventario */

?>

<h3>Control de recibos</h3>

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
)); ?>

<div class="row"> 
  <div class="col-sm-4">
    <div class="form-group">
      <?php echo $form->error($model,'fecha_inicial', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'fecha_inicial'); ?>
      <?php echo $form->textField($model,'fecha_inicial', array('class' => 'form-control', 'readonly' => true)); ?>
    </div>
  </div> 
  <div class="col-sm-4">
    <div class="form-group">
      <?php echo $form->error($model,'fecha_final', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'fecha_final'); ?>
      <?php echo $form->textField($model,'fecha_final', array('class' => 'form-control', 'readonly' => true)); ?>
    </div>
  </div>  
	<div class="col-sm-4">
    	<div class="form-group">
			<?php echo $form->error($model,'opcion_exp', array('class' => 'pull-right badge bg-red')); ?>
    	<?php echo $form->label($model,'opcion_exp'); ?><br>
			<?php 
				echo $form->radioButtonList($model,'opcion_exp',
			    	array('3'=>'<i class="fa fa-desktop" aria-hidden="true"></i> Pantalla','2'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i> EXCEL'),
			    	array(
			        	'template'=>'{input}{label}',
			        	'separator'=>'',
			        	'labelOptions'=>array(
			            	'style'=> '
			                	padding-left:1%;
			                	padding-right:5%;
		            	'),
		          	)                              
		      	);
			?>			
    	</div>
    </div>
</div>
    
<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
    <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-bar-chart"></i> Generar</button>
    </div>


<div class="row">
    <div class="col-lg-12 table-responsive" id="resultados">
    <!-- contenido via ajax -->
    </div>
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
              $("#resultados").html(''); 
              //se envia el form
              if($("input:radio:checked").val() == 3){
                reporte_pantalla();
              }else{
                form.submit();
                $(".ajax-loader").fadeIn('fast');
                setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 5000); 
              }  
          } else {
              settings = form.data('settings'),
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });
              settings.submitting = false ;
          }
      });
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

  $("#Reporte_fecha_inicial").datepicker({
      language: 'es',
      autoclose: true,
      orientation: "right bottom",
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    var maxDate = new Date(selected.date.valueOf());
    maxDate.setDate(maxDate.getDate() + 30);
    $('#Reporte_fecha_final').datepicker('setStartDate', minDate);
    $('#Reporte_fecha_final').datepicker('setEndDate', maxDate);
  });

  $("#Reporte_fecha_final").datepicker({
      language: 'es',
      autoclose: true,
      orientation: "right bottom",
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    var minDate = new Date(selected.date.valueOf());
    minDate.setDate(minDate.getDate() - 30);
    $('#Reporte_fecha_inicial').datepicker('setStartDate', minDate);
    $('#Reporte_fecha_inicial').datepicker('setEndDate', maxDate);
  });

});

function reporte_pantalla(){

  var fecha_inicial = $("#Reporte_fecha_inicial").val();
  var fecha_final = $("#Reporte_fecha_final").val();

  var data = {fecha_inicial: fecha_inicial, fecha_final: fecha_final}
  $(".ajax-loader").fadeIn('fast');
  $.ajax({ 
    type: "POST", 
    url: "<?php echo Yii::app()->createUrl('reporte/controlrecibospant'); ?>",
    data: data,
    success: function(data){ 
      $(".ajax-loader").fadeOut('fast');
      $("#resultados").html(data); 
    }
  });
}

function resetfields(){
  $(".ajax-loader").fadeIn('fast');
  $("#resultados").html('');
  $('#Reporte_fecha_inicial').val('');
  $('#Reporte_fecha_inicial').datepicker('setStartDate', '');
  $('#Reporte_fecha_inicial').datepicker('setEndDate', '');
  $('#Reporte_fecha_final').val('');
  $('#Reporte_fecha_final').datepicker('setStartDate', '');
  $('#Reporte_fecha_final').datepicker('setEndDate', '');
  $(".ajax-loader").fadeOut('fast');
}

</script>