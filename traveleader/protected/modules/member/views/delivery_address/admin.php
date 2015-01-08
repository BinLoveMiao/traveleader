<?php
$this->breadcrumbs = array(
Yii::t('main', 'contact') => array('admin'),
);
?>

<div class="box">
    <div class="box-title"><?php echo Yii::t('main', 'contact'); ?></div>
    <div class="box-content">
         <span id="item" style="margin:10px 0px 0px 0px;">已保存有效的地址:</span>

         <?php $this->widget('bootstrap.widgets.TbGridView', array(
            	'type'=>'striped bordered condensed',
                'dataProvider'=>$dataProvider,
                'columns'=>array(
                    'contact_name',
                    's.name',
                    'c.name',
                    'd.name',
                    //'address',
                    //'zipcode',
                    'phone' ,
					'email',
                    'mobile_phone' ,
                    'memo' ,
                    array(
                        'name' => 'is_default',
                        'value' => 'Tbfunction::ShowYesOrNo($data->is_default)',
                    ),
                    array(
                        'name' => 'create_time',
                        'value' => 'date("Y-m-d", $data->create_time)',
                        'htmlOptions' => array('style'=>'width:100px')
                    ),
                    array(
                        'name' => 'update_time',
                        'value' => 'date("Y-m-d", $data->update_time)',
                        'htmlOptions' => array('style'=>'width:100px')
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{view}{update}{delete}',
                        'viewButtonUrl' => 'Yii::app()->createUrl("/member/delivery_address/view/id/".$data->contact_id)',
                    ),
                ),
            )); ?>
    
        <span id="item" style="margin-left:0px" >新建联系人信息：</span>

        <!--后面新改的会员中心 联系人部分-->
        <div style="width:80%" class="form-horizontal">
            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
    </div>


</div>
