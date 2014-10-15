<?php
$this->breadcrumbs = array(
'收货地址' => array('admin'),
'管理',
);
?>

<div class="box">
    <div class="box-title">收货地址</div>
    <div class="box-content">
        <span id="item" style="margin-left:0px" >新建收货地址：</span>
<!--         --><?php //$this->widget('bootstrap.widgets.TbGridView', array(
//        'dataProvider'=>$dataProvider,
//        'type' => 'striped bordered condensed',
//        'columns'=>array(
//            'contact_name',
//            's.name',
//            'c.name',
//            'd.name',
//            'address',
//            'zipcode',
//            'phone' ,
//            'mobile_phone' ,
//            'memo' ,
//            array(
//            'name' => 'is_default',
//            'value' => 'Tbfunction::ShowYesOrNo($data->is_default)',
//            ),
//            array(
//            'name' => 'create_time',
//            'value' => 'date("Y-m-d", $data->create_time)',
//            'htmlOptions' => array('style'=>'width:100px')
//            ),
//            array(
//            'name' => 'update_time',
//            'value' => 'date("Y-m-d", $data->update_time)',
//            'htmlOptions' => array('style'=>'width:100px')
//            ),
//            array(
//                'class' => 'bootstrap.widgets.TbButtonColumn',
//            ),
//        ),
//        )); ?>
        <!--后面新改的会员中心 收货地址部分-->
        <div style="width:80%" class="form-horizontal">
            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
         <span id="item" style="margin:30px 0px 20px 0px;">已保存有效的地址:</span>

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'dataProvider'=>$dataProvider,
                'columns'=>array(
                    'contact_name',
                    's.name',
                    'c.name',
                    'd.name',
                    'address',
                    'zipcode',
                    'phone' ,
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


    </div>


</div>
