<?php
$this->breadcrumbs=array(
	'发表游记',
);
?>
<h1>发表游记</h1>

<?php echo $this->renderPartial('_form', 
		array('model'=>$model, 
		'default_scenery'=>$default_scenery,
		'default_state'=>$default_state,
		'default_city'=>$default_city,
		'image'=>$image,
		)); ?>