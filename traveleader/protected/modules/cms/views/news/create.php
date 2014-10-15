<?php
$this->breadcrumbs=array(
	'Post'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Post', 'icon'=>'list', 'url'=>array('index')),
	array('label'=>'Manage Post', 'icon'=>'cog','url'=>array('admin')),
);
?>

<h1>Create News</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>