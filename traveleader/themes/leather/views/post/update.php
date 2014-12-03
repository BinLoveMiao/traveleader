<?php
$this->breadcrumbs=array(
	$model->title=>$model->url,
	'Update',
);
?>

<h1>Update <i><?php echo CHtml::encode($model->title); ?></i></h1>

<?php echo $this->renderPartial('_form', 
		array('model'=>$model,
			'default_scenery'=>$default_scenery,
			'default_state'=>$default_state,
			'default_city'=>$default_city,
			'image'=>$image,	
		)); ?>