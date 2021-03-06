<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-form',
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
    		<?php echo $form->error($model,'Nombres', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Nombres'); ?>
		    <?php echo $form->textField($model,'Nombres', array('class' => 'form-control', 'maxlength' => '60', 'autocomplete' => 'off')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Correo', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Correo'); ?>
		    <?php echo $form->textField($model,'Correo', array('class' => 'form-control', 'maxlength' => '50', 'autocomplete' => 'off')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Usuario', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Usuario'); ?>
		    <?php echo $form->textField($model,'Usuario', array('class' => 'form-control', 'maxlength' => '30', 'autocomplete' => 'off')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Password', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Password'); ?>
		    <input type="password" name="Usuario[Password]" id="Usuario_Password" class="form-control" autocomplete="off">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Estado', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Estado'); ?>
            <?php $estados = Yii::app()->params->estados; ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Usuario[Estado]',
                    'id'=>'Usuario_Estado',
                    'data'=>$estados,
                    'value' => $model->Estado,
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
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->error($model,'perfiles', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'perfiles'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Usuario[perfiles]',
                    'id'=>'Usuario_perfiles',
                    'data'=>$lista_perfiles,
                    'htmlOptions'=>array(
                        'multiple'=>'multiple',
                    ),
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
    
<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=usuario/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="submit" class="btn btn-success" ><i class="fa fa-floppy-o"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
</div>

<?php $this->endWidget(); ?>








