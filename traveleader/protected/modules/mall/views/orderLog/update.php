<?php
$this->breadcrumbs=array(
	'Order Logs'=>array('index'),
	$model->log_id=>array('view','id'=>$model->log_id),
	'Update',
);

?>

<h1>Update OrderLog <?php echo $model->log_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>