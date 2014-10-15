<?php
$this->breadcrumbs=array(
	'Shipping Methods'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ShippingMethod', 'icon'=>'list', 'url'=>array('index')),
	array('label'=>'Create ShippingMethod', 'icon'=>'plus','url'=>array('create')),
	array('label'=>'Update ShippingMethod', 'icon'=>'pencil','url'=>array('update', 'shipping_method_id'=>$model->shipping_method_id)),
	array('label'=>'Delete ShippingMethod', 'icon'=>'trash', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','shipping_method_id'=>$model->shipping_method_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShippingMethod', 'icon'=>'cog','url'=>array('admin')),
);
?>

<h3>查看支付方式 #<?php echo $model->shipping_method_id; ?></h3>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'shipping_method_id',
		'code',
		'name',
		'desc',
		'enabled',
		'is_cod',
		'sort_order',
	),
)); ?>
