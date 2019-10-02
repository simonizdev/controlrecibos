<?php
/* @var $this RevRecibosController */
/* @var $model RevRecibos */
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
	          	<?php echo $form->label($model,'recibo'); ?>
			    <?php echo $form->textField($model,'recibo', array('class' => 'form-control', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'usuario_rev'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'RevRecibos[usuario_rev]',
						'id'=>'RevRecibos_usuario_rev',
						'data'=>$lista_usuarios,
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
	          	<?php echo $form->label($model,'fecha_rev'); ?>
			    <?php echo $form->textField($model,'fecha_rev', array('class' => 'form-control datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
    	<div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Opc'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'RevRecibos[Opc]',
						'id'=>'RevRecibos_Opc',
						'data'=>array(2 => "VERIFICADO", 3 => "APLICADO"),
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
	</div>

	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php 
					$this->widget('application.extensions.PageSize.PageSize', array(
					        'mGridId' => 'usuario-grid', //Gridview id
					        'mPageSize' => @$_GET['pageSize'],
					        'mDefPageSize' => Yii::app()->params['defaultPageSize'],
					        'mPageSizeOptions'=>Yii::app()->params['pageSizeOptions'],// Optional, you can use with the widget default
					)); 
				?>	
	        </div>
	    </div>
	</div>
	<div class="btn-group" style="padding-bottom: 2%">
		<button type="button" class="btn btn-success" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
		<button type="submit" class="btn btn-success" id="yt0"><i class="fa fa-search"></i> Buscar</button>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

	function resetfields(){
		$('#RevRecibos_recibo').val('');
		$('#RevRecibos_usuario_rev').val('').trigger('change');
		$('#RevRecibos_fecha_rev').val('');
		$('#RevRecibos_Opc').val('').trigger('change');
		$('#yt0').click();
	}
	
</script>