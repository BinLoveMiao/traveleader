<?php

$this->breadcrumbs = array(
    '我的收藏' => array('admin'),
    '管理',
);
?>

<div class="box">
    <div class="box-title">我的收藏夹</div>
    <div class="box-content">
        <?php
        $url = Yii::app()->baseUrl . '/item/';
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'wishlist-grid',
        	'type'=>'striped bordered condensed',
            'dataProvider' => $model->MyCollectSearch(),
            'columns' => array(
            	array(
        			'name' => 'ITEM_pic',
            		'type' => 'raw',
            		'value' => '"<img src=". Yii::app()->baseUrl. $data->item->getMainPic(50,65). 
            			" width=65 height=50>"',
            		'htmlOptions' => array('style' => 'width:10%;')
        		),
                array(
                    'class' => 'CLinkColumn',
                    'header' => '产品价格',
                    'labelExpression' => '$data->item->title',
                    'urlExpression' => 'Yii::app()->createUrl("item",array("view"=>$data->item->item_id))',
                	'htmlOptions' => array('style' => 'width:40%;')
                ),
                array(
                    'name' => 'ITEM_price',
                    'value' => '$data->item->price',
                	'htmlOptions' => array('style' => 'width:10%;')
                ),
                //array(
                 //   'name' => 'stock',
                //    'value' => '$data->item->stock',
                //),
                array(
                    'name' => 'create_time',
                    'value' => 'date("Y-m-d", $data->create_time)',
                    'htmlOptions' => array('style' => 'width:10%')
                ),
            	array(
            		'name' => 'desc',
            		'value' => '$data->desc',
            		'htmlOptions' => array('style' => 'width:10%')
            	),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{view}{update}{delete}',
                    'viewButtonUrl' => 'Yii::app()->createUrl("/item/view",
                    array("id" => $data->item_id))',
                	'htmlOptions' => array('style' => 'width:20%')
                ),
            ),
        ));
        ?>
    </div>
</div>

