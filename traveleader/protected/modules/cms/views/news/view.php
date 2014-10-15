<?php
$this->breadcrumbs=array(
	'Post'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List News', 'icon'=>'list', 'url'=>array('index')),
	array('label'=>'Create News', 'icon'=>'plus','url'=>array('create')),
	array('label'=>'Update News', 'icon'=>'pencil','url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete News', 'icon'=>'trash', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage News', 'icon'=>'cog','url'=>array('admin')),
);
?>

<h1>View News #<?php echo $model->id; ?></h1>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'store_id',
		'category_id',
		'title',
		'source',
		'content:html',
		'views',
        'tags',
        'status',
        'author',
        'user_id',
        'url',
        'pic_url',
        'summary',
        'language',
		array(
            'name' => 'create_time',
            'value' => date("Y年m月d日 H:i:s",$model->create_time+8*3600 )
        ),
        array(
            'name' => 'update_time',
            'value' => date("Y年m月d日 H:i:s",$model->create_time+8*3600 )
        ),
	),
)); ?>
