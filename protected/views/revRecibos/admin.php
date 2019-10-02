<?php
/* @var $this RevRecibosController */
/* @var $model RevRecibos */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle('');
	return false;
});
$('.search-form form').submit(function(){
	$('#rev-recibos-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Usuario', 'Usuario'); 
?>

<h3>Log de reversiones</h3>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
</div>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
    'lista_usuarios' => $lista_usuarios,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'rev-recibos-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'enableSorting' => false,
	'columns'=>array(
		//'Id_Reversion',
		array(
            'name'=>'recibo',
            'value'=>'$data->idcontrol->Recibo',
        ),
		array(
            'name'=>'Id_Usuario_Rev',
            'value'=>'$data->idusuariorev->Usuario',
        ),
        array(
            'name'=>'Fecha_Hora_Rev',
            'value'=>'UtilidadesVarias::textofechahora($data->Fecha_Hora_Rev)',
        ),
        array(
            'name' => 'Opc',
            'type' => 'raw',
            'value' => '($data->Opc == "2") ? "VERIFICADO" : "APLICADO"',
        ),
		/*
		'Id_Usuario_Verif',
		'Fecha_Hora_Verif',
		'Id_Usuario_Aplic',
		'Fecha_Hora_Aplic',
		*/
		array(
			'class'=>'CButtonColumn',
            'template'=>'{view}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'<i class="fa fa-eye actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                ),
            )
		),
	),
)); ?>
