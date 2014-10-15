<?php
$this->breadcrumbs=array(
	'Order Logs',
);

?>

<h1>Order Logs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
