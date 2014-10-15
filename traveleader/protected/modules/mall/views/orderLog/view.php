<?php
$this->breadcrumbs=array(
	'Order Logs'=>array('index'),
	$model->log_id,
);

?>

<h3>查看订单日志 #<?php echo $model->log_id; ?></h3>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'log_id',
		'order_id',
		'op_name',
        array(
            'name' => 'action_time',
            'value' => date("Y年m月d日 H:i:s",$model->action_time),
        ),
        array(
            'name' => 'log_text',
            'value' =>$model->showOp($model->log_id)
        ),
		'user_id',
		'result',
	),
)); ?>

<script>
    $('table[id=yw0]').removeClass().addClass('table table-bordered table-condensed').css('width','30%');

</script>