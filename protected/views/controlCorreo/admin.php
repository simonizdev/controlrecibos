<?php
/* @var $this ControlCorreoController */
/* @var $model ControlCorreo */

Yii::app()->clientScript->registerScript('search', "
$('#export-excel').on('click',function() {
    $.fn.yiiGridView.export();
});
$.fn.yiiGridView.export = function() {
    $.fn.yiiGridView.update('control-correo-grid',{ 
        success: function() {
            window.location = '". $this->createUrl('exportexcel')  . "';
            $(\".ajax-loader\").show();
            setTimeout(function(){ $(\".ajax-loader\").hide(); }, 20000);
        },
        data: $('.search-form form').serialize() + '&export=true'
    });
}
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#control-correo-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Log de correo (control de recibos)</h3>

<button type="button" class="btn btn-success search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
<?php if(Yii::app()->user->getState("permiso_act") == true) { ?>
<button type="button" class="btn btn-success" id="export-excel"><i class="fa fa-file-excel-o"></i> Exportar a excel</button>
<?php } ?>

<div class="search-form" style="display:none;padding-top: 2%;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'control-correo-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'enableSorting' => false,
	'columns'=>array(
		'ROWID',
		'ID',
		'ASUNTO',
		'REMITENTE',
		'ANEXOS',
		array(
            'name'=>'FECHA',
            'value'=>'UtilidadesVarias::textofechahora($data->FECHA)',
        ),
        array(
            'name'=>'REGISTRO',
            'value'=>'UtilidadesVarias::textofechahora($data->REGISTRO)',
        ),
	),
)); ?>
