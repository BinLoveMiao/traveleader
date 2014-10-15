<?php
header("Content-Type: text/html; charset=utf-8");
$this->breadcrumbs=array(
	'Articles',
);

$this->menu=array(
	array('label'=>'Create Article', 'icon'=>'plus','url'=>array('create')),
	array('label'=>'Manage Article', 'icon'=>'cog','url'=>array('admin')),
);
?>

<h1>Articles</h1>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
