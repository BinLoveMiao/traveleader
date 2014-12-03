<?php
//$this->breadcrumbs=array(
//	$model->title,
//);
$this->pageTitle=$model->title;
?>

<?php $this->renderPartial('_view', array(
	'data'=>$model,
)); 

?>

<?php $this->renderPartial('comment.views.comment.commentList', array(
    'model'=>$model
)); ?>