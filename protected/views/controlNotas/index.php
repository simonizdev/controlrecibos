<?php
/* @var $this ControlNotasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Control Notases',
);

$this->menu=array(
	array('label'=>'Create ControlNotas', 'url'=>array('create')),
	array('label'=>'Manage ControlNotas', 'url'=>array('admin')),
);
?>

<h1>Control Notases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
