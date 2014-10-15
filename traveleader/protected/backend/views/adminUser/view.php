<?php
$this->breadcrumbs=array(
	'Admin Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'创建管理员','icon'=>'plus','url'=>array('create')),
	array('label'=>'更新管理员','icon'=>'pencil','url'=>array('update','id'=>$model->id)),
	array('label'=>'删除管理员','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'管理员列表','icon'=>'cog','url'=>array('admin')),
);
?>

<h2 align="center">View AdminUser #<?php echo $model->id; ?></h2>
<!--注释掉的部分
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'email',
		'profile',
	),
)); ?>    -->
 <div class="container" id="demo-table" >
   <table class="table table-striped table-bordered">
       <tr>
           <th class="col-xs-2">ID</th>
           <td class="col-xs-4">1</td>
       </tr>
       <tr>
           <th class="col-xs-2">Username：</th>
           <td class="col-xs-4">demo</td>
       </tr>
       <tr>
           <th class="col-xs-2">Password：</th>
           <td class="col-xs-4">xxxx</td>
       </tr>
       <tr>
           <th class="col-xs-2">Email：</th>
           <td class="col-xs-4">xx@qq.com</td>
       </tr>
       <tr>
           <th class="col-xs-2">profile：</th>
           <td class="col-xs-4">xxxxx</td>
       </tr>



   </table>
</div>