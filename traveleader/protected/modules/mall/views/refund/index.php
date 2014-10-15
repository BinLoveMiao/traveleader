<?php
$this->breadcrumbs=array(
	'Refunds',
);


?>

<h1>Refunds</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
