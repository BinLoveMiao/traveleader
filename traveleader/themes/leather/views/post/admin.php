<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/post.css');
$this->breadcrumbs=array(
	'Manage Posts',
);
?>

<h1>管理游记 </h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$data,
	'filter'=>new Post(),
	'columns'=>array(
		array(
			'name'=>'title',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->title), $data->url)',
			'htmlOptions'=>array('style'=>
					'text-align: left; width: 40%; white-space: nowrap;
					overflow: hidden; text-overflow: ellipsis;')
		),
		array(
			'name'=>'status',
			'value'=>'Lookup::item("PostStatus",$data->status)',
			'filter'=>Lookup::items('PostStatus'),
			'htmlOptions'=>array('style'=>
						'text-align: center; width: 8%;')
		),
		array(
			'name'=>'views',
			'value'=>'$data->views',
			'filter'=>false,
			'htmlOptions'=>array('style'=>
					'text-align: center; width: 8%;')
		),
		array(
				'name'=>'ding',
				'value'=>'$data->ding',
				'filter'=>false,
				'htmlOptions'=>array('style'=>
					'text-align: center; width: 8%;')
		),
		array(
			'name'=>'create_time',
			'type'=>'datetime',
			'filter'=>false,
			'htmlOptions'=>array('style'=>
				'text-align: center; width: 20%;')
		),
		array(
			'class'=>'CButtonColumn',
			'htmlOptions'=>array('style'=>
				'text-align: center; width: 10%;')
		),
	),
)); ?>
