<?php
$this->breadcrumbs=array(
	'Payment Methods'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>"支付方式清单", 'icon'=>'list', 'url'=>array('index')),
	array('label'=>'选择支付方式', 'icon'=>'plus','url'=>array('create')),
);
?>

<h3>支付方式</h3>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'payment-method-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'payment_method_id',
//		'code',
		'name',
		'desc',
//		'config',
        array(
            'name' => 'enabled',
            'value' => 'Tbfunction::showYesOrNo($data->enabled)',
            'filter' => Tbfunction::ReturnYesOrNo(),
        ),
		/*
		'is_cod',
		'is_online',
		'sort_order',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
