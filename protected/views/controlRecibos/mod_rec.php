<?php
/* @var $this ControlRecibosController */
/* @var $model ControlRecibos */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#control-recibos-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Modificación de recibos</h3>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i>Realizado</h4>
      <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?> 

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
</div>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search_mod_rec',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'control-recibos-grid',
	'dataProvider'=>$model->search_mod_rec(),
	//'filter'=>$model,
    'enableSorting' => false,
	'columns'=>array(
		'Recibo',
        array(
            'name'=>'Id_Usuario_Carga',
            'value'=>'$data->idusuariocarga->Usuario',
        ),
        array(
            'name'=>'Fecha_Hora_Carga',
            'value'=>'UtilidadesVarias::textofechahora($data->Fecha_Hora_Carga)',
        ),
		array(
            'class'=>'CButtonColumn',
            'template'=>'{update}',
            'buttons'=>array(
                'update'=>array(
                    'label'=>'<i class="fa fa-refresh actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Cambiar imagen de recibo'),
                    'url'=>'Yii::app()->createUrl("controlRecibos/update", array("id"=>$data->Id_Control))',
                ),
            )
        ),
	),
)); ?>
