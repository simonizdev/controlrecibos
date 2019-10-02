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

<h3>Reversión estado de recibos</h3>

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

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search_estados',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'control-recibos-grid',
	'dataProvider'=>$model->search_estados(),
	//'filter'=>$model,
    'enableSorting' => false,
	'columns'=>array(
		'Recibo',
		array(
            'name'=>'Opc',
            'value'=>'$data->Desc_Opc($data->Opc)',
        ),
        array(
            'name'=>'Verificacion',
            'value' => '($data->Verificacion == "") ? "NO ASIGNADO" : $data->Desc_Verif($data->Verificacion)',
        ), 
		array(
            'class'=>'CButtonColumn',
            'template'=>'{update}',
            'buttons'=>array(
                'update'=>array(
                    'label'=>'<i class="fa fa-arrow-circle-left actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Revertir estado de recibo'),
                    'url'=>'Yii::app()->createUrl("controlRecibos/revrec", array("id"=>$data->Id_Control))',
                ),
            )
        ),
	),
)); ?>
