<?php
/* @var $this RevRecibosController */
/* @var $model RevRecibos */
?>

<h3>Visualizando detalle de reversión</h3>

<div class="table-responsive">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id_Reversion',
		array(
            'name'=>'Id_Control',
            'value'=>$model->idcontrol->Recibo,
        ),
		array(
            'name'=>'Id_Usuario_Rev',
            'value'=>$model->idusuariorev->Usuario,
        ),
        array(
            'name'=>'Fecha_Hora_Rev',
            'value'=>UtilidadesVarias::textofechahora($model->Fecha_Hora_Rev),
        ),
        array(
            'name' => 'Opc',
            'type' => 'raw',
            'value' => ($model->Opc == "2") ? "VERIFICADO" : "APLICADO",
        ),
        array(
            'name'=>'Id_Usuario_Verif',
            'value'=>$model->idusuarioverif->Usuario,
        ),
        array(
            'name'=>'Fecha_Hora_Verif',
            'value'=>UtilidadesVarias::textofechahora($model->Fecha_Hora_Verif),
        ),
        array(
            'name'=>'Id_Usuario_Aplic',
            'value'=>($model->Id_Usuario_Aplic == "") ? "N/A" : $model->idusuarioaplic->Usuario,
        ),
        array(
            'name'=>'Fecha_Hora_Aplic',
            'value'=>($model->Fecha_Hora_Aplic == "") ? "N/A" : UtilidadesVarias::textofechahora($model->Fecha_Hora_Aplic),
        ),

	),
)); ?>

</div>

<div class="btn-group" style="padding-bottom: 2%">
   <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=revRecibos/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
</div>
