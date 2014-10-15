 <div class="view">
   <div class="view-txt" id="accordion">
	<p class="text-muted"><?php echo CHtml::encode($data->getAttributeLabel('article_id')); ?>:&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo CHtml::link(CHtml::encode($data->article_id), array('view', 'id'=>$data->article_id)); ?>
	</p>


	<p><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo CHtml::encode($data->category_id); ?></p>


	<p><?php echo CHtml::encode($data->getAttributeLabel('author_id')); ?>:&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo CHtml::encode($data->author_id); ?></p>


	<p><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</p>
	<p  class="text-warning"><?php echo CHtml::encode($data->title); ?></p>


	<p "><?php echo CHtml::encode($data->getAttributeLabel('from')); ?>:&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo CHtml::encode($data->from); ?>
	</p>

	<p class="text-danger"><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</p>
	<p class="text-success"><?php echo CHtml::encode($data->content); ?></p>


	<p><?php echo CHtml::encode($data->getAttributeLabel('views')); ?>:&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo CHtml::encode($data->views); ?>
    </p>
<br />
<br />


	<?php /*
	<p><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</p>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<p><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</p>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	*/ ?>
 </div>
</div>

