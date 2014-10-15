<?php
$this->breadcrumbs=array(
	'配送方式'=>array('index'),
	'管理',
);

$this->menu=array(
	array('label'=>Yii::t('backend','配送方式清单'), 'icon'=>'list', 'url'=>array('index')),
	array('label'=>Yii::t('backend','选择配送方式'), 'icon'=>'plus','url'=>array('create')),
);
?>



<h1><?php echo Yii::t('backend','配送方式');?></h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'shipping-method-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'shipping_method_id',
		'code',
		'name',
		'desc',
        array(
            'name' => 'enabled',
            'value' => 'Tbfunction::showYesOrNo($data->enabled)',
            'filter' => Tbfunction::ReturnYesOrNo(),
        ),
        array(
            'name' => 'is_cod',
            'value' => 'Tbfunction::showYesOrNo($data->is_cod)',
            'filter' => Tbfunction::ReturnYesOrNo(),
        ),
		/*
		'sort_order',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
