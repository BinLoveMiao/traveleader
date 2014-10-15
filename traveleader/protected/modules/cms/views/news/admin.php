<?php
$this->breadcrumbs=array(
	'新闻'=>array('index'),
	'管理',
);

$this->menu=array(
	array('label'=>'创建新闻', 'icon'=>'plus','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('post-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>新闻文章</h1>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'post-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'category.name',
		'author',
		'title',
        'content',
        'tags',
		'source',
        'language',
        'pic_url',
//		'views',
//		'create_time',
//		'update_time',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>