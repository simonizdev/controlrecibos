<?php
/* @var $this ControlNotasController */
/* @var $model ControlNotas */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#control-notas-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Usuario', 'Usuario'); 

?>

<h3>Consulta de notas</h3>

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
	'id'=>'control-notas-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'enableSorting' => false,
	'columns'=>array(
		'Id_Control',
		array(
            'name'=>'Id_Cliente',
            'value'=>'$data->Desc_Cliente($data->Id_Cliente)',
        ),
		array(
            'name' => 'Nota',
            'type' => 'raw',
            'value' => '($data->Nota == "") ? "SIN ASIGNAR" : $data->Nota',
        ),
		'Factura',
		//'Valor_Factura',
		//'Porc_Desc',
		//'Valor_Descuento',
		array(
            'name'=>'Fecha_Factura',
            'value'=>'UtilidadesVarias::textofecha($data->Fecha_Factura)',
        ),
        array(
            'name'=>'Fecha_Pago',
            'value'=>'UtilidadesVarias::textofecha($data->Fecha_Pago)',
        ),
        'Recibo',
		//'Dias_Pago',
		//'Observaciones',
        array(
            'name'=>'Respuesta',
            'value'=>'$data->Desc_Respuesta($data->Respuesta)',
        ),
		/*'Id_Usuario_Creacion',
		'Id_Usuario_Actualizacion',
		'Fecha_Creacion',
		'Fecha_Actualizacion',*/
		array(
			'class'=>'CButtonColumn',
            'template'=>'{view}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'<i class="fa fa-eye actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                    'url'=>'Yii::app()->createUrl("controlNotas/view", array("id"=>$data->Id_Control, "opc"=>2))',
                ),
            )
		),
	),
)); ?>
