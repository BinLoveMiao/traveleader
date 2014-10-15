<?php
$this->breadcrumbs=array(
	'Post'=>array('index'),
	''=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Post', 'icon'=>'list', 'url'=>array('index')),
	array('label'=>'Create Post', 'icon'=>'plus','url'=>array('create')),
	array('label'=>'View Post', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Post', 'icon'=>'cog','url'=>array('admin')),
);
?>

<h1>Update News <?php echo $model->id; ?></h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>