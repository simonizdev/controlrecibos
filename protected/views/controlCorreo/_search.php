<?php
/* @var $this ControlCorreoController */
/* @var $model ControlCorreo */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<p>Utilice los filtros para optimizar la busqueda:</p>

	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'ROWID'); ?>
			    <?php echo $form->numberField($model,'ROWID', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'ID'); ?>
			    <?php echo $form->textField($model,'ID', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'ASUNTO'); ?>
			    <?php echo $form->textField($model,'ASUNTO', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'REMITENTE'); ?>
			    <?php echo $form->textField($model,'REMITENTE', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
		<div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'ANEXOS'); ?>
			    <?php echo $form->textField($model,'ANEXOS', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'fecha_correo_inicial'); ?>
			    <?php echo $form->textField($model,'fecha_correo_inicial', array('class' => 'form-control', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'fecha_correo_final'); ?>
			    <?php echo $form->textField($model,'fecha_correo_final', array('class' => 'form-control', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'fecha_registro_inicial'); ?>
			    <?php echo $form->textField($model,'fecha_registro_inicial', array('class' => 'form-control', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'fecha_registro_final'); ?>
			    <?php echo $form->textField($model,'fecha_registro_final', array('class' => 'form-control', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'orderby'); ?>
			    <?php 
                	$array_orden = array(1 => 'ID ASC', 2 => 'ID DESC', 3 => 'Id Correo ASC', 4 => 'Id Correo DESC', 5 => 'Asunto de correo ASC', 6 => 'Asunto de correo DESC', 7 => 'Remitente de correo ASC', 8 => 'Remitente de correo DESC', 9 => 'Adjunto ASC', 10 => 'Adjunto DESC', 11 => 'Fecha y hora de correo ASC', 12 => 'Fecha y hora de correo DESC', 13 => 'Fecha y hora de registro ASC', 14 => 'Fecha y hora de registro DESC',
                	);
            	?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'ControlCorreo[orderby]',
						'id'=>'ControlCorreo_orderby',
						'data'=>$array_orden,
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
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php 
					$this->widget('application.extensions.PageSize.PageSize', array(
					        'mGridId' => 'control-correo-grid', //Gridview id
					        'mPageSize' => @$_GET['pageSize'],
					        'mDefPageSize' => Yii::app()->params['defaultPageSize'],
					        'mPageSizeOptions'=>Yii::app()->params['pageSizeOptions'],// Optional, you can use with the widget default
					)); 
				?>	
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	    		<button type="button" class="btn btn-success" onclick="resetfields();">Limpiar filtros</button>
	    		<?php echo CHtml::submitButton('Buscar', array('class' => 'btn btn-success', 'id' => 'yt0')); ?>
	        </div>
	    </div>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">


	$(function() {

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

		$("#ControlCorreo_fecha_correo_inicial").datepicker({
		  language: 'es',
		  autoclose: true,
		  orientation: "right bottom",
		}).on('changeDate', function (selected) {
		   var minDate = new Date(selected.date.valueOf());
		   $('#ControlCorreo_fecha_correo_final').datepicker('setStartDate', minDate);
		});

		$("#ControlCorreo_fecha_correo_final").datepicker({
		  language: 'es',
		  autoclose: true,
		  orientation: "right bottom",
		}).on('changeDate', function (selected) {
		   var maxDate = new Date(selected.date.valueOf());
		   $('#ControlCorreo_fecha_correo_inicial').datepicker('setEndDate', maxDate);
		}); 

		$("#ControlCorreo_fecha_registro_inicial").datepicker({
		  language: 'es',
		  autoclose: true,
		  orientation: "right bottom",
		}).on('changeDate', function (selected) {
		   var minDate = new Date(selected.date.valueOf());
		   $('#ControlCorreo_fecha_registro_final').datepicker('setStartDate', minDate);
		});

		$("#ControlCorreo_fecha_registro_final").datepicker({
		  language: 'es',
		  autoclose: true,
		  orientation: "right bottom",
		}).on('changeDate', function (selected) {
		   var maxDate = new Date(selected.date.valueOf());
		   $('#ControlCorreo_fecha_registro_inicial').datepicker('setEndDate', maxDate);
		}); 

	});

	function resetfields(){
		$('#ControlCorreo_ROWID').val('');
		$('#ControlCorreo_ID').val('');
		$('#ControlCorreo_ASUNTO').val('');
		$('#ControlCorreo_REMITENTE').val('');
		$('#ControlCorreo_ANEXOS').val('');
		$('#ControlCorreo_fecha_correo_inicial').val('');
		$('#ControlCorreo_fecha_correo_final').val('');
		$('#ControlCorreo_fecha_registro_inicial').val('');
		$('#ControlCorreo_fecha_registro_final').val('');
		$('#ControlCorreo_orderby').val('').trigger('change');
		$('#yt0').click();
	}
	
</script>
