<?php
$this->breadcrumbs=array(
	'Refunds'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>"退货单",'url'=>array('index')),
	array('label'=>"申请退货",'url'=>array('create')),
);

?>

<h3>退货单</h3>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'refund-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'refund_id',
		'refund_sn',
		'money',
		'currency',
		'order_id',
		'pay_method',
		/*
		'user_id',
		'account',
		'bank',
		'refund_account',
		'status',
		'create_time',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
