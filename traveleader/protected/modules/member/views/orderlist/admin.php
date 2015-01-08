<?php
$this->breadcrumbs = array(
    Yii::t('main', 'my order') => array('admin'),
);
?>

<div class="box">
    <div class="box-title"><?php echo Yii::t('main', 'order manager');?></div>
    <div class="box-content clearfix">
      <?php
      	    $order_columns=array(
      	    	//array(
      	    	//	'name' => 'order_id',
               // 	'value' =>'$data->order_id',
      	    	//	'filter' => false,
      	    	//	'htmlOptions'=>array('style'=>
      	    	//				'width: 10%; white-space: nowrap;
				//				overflow: hidden; text-overflow: ellipsis;')
      	    	//),
                //array(
                //    'name' => 'status',
                //    'value' => 'Tbfunction::showOrderStatus($data->status)',
               //     'filter' => Tbfunction::ReturnOrderStatus(),
                //),
      	    	//array(
      	    	//		'name' => 'create_time',
      	    	//		'value' => 'date("Y-m-d", $data->create_time)',
      	    	//		'filter' => false,
      	    	//		'htmlOptions'=>array('style'=>
      	    	//				'width: 10%;')
      	    	//),
               // 'total_fee',
                //'pay_fee',
      	    	array(
      	    		'name' => 'order_detail',
      	    		'type' => 'raw',
      	    		'value' => '"<dl><dt style=width:35%;float:left>".$data->getAttributeLabel("order_id").": </dt><a href=". Yii::app()->createUrl("member/orderlist/detail-".$data->order_id).
      	    					"><dd style=width:65%;float:left>".$data->order_id."</dd></a>".
      	    				"<dt style=width:35%;float:left>".$data->getAttributeLabel("create_time").": </dt><dd style=width:65%;float:left>".date("Y-m-d", $data->create_time)."</dd>".
      	    				"<dt style=width:35%;float:left>".$data->getAttributeLabel("total_fee").": </dt><dd style=width:65%;float:left>".$data->total_fee."</dd></dl>"
      	    			',
      	    		'filter' => false,
      	    		'htmlOptions' => array('style'=>
      	    					'width: 30%; text-align: left')	
      	    	),
      	    	array(
      	    		'name' => 'ORDERITEM_title',
      	    		'type' => 'raw',
                	'value' => '"<a href=" .Yii::app()->createUrl("item/view", array("id"=>$data->ORDERITEM_item_id)).
      	    						">".$data->ORDERITEM_title."</a>"',
      	    		'htmlOptions'=>array('style'=>
      	    			'width: 30%; white-space: nowrap;
						overflow: hidden; text-overflow: ellipsis;')
      	    	),

                array(
                    'name' => 'ORDERITEM_status',
                    'value' => 'Tbfunction::showOrderStatus($data->ORDERITEM_status)',
                    'filter' => Tbfunction::ReturnOrderStatus(),
                	'htmlOptions'=>array('style'=>
                			'width: 10%;text-align:center')
                ),
                array(
                    'name' => 'ORDERITEM_is_review',
                    'value' => 'Tbfunction::showReviewStatus($data->ORDERITEM_is_review)',
                    'filter' => Tbfunction::ReturnReviewStatus(),
                	'htmlOptions'=>array('style'=>
                			'width: 10%;text-align:center')
                ),
                array(
                    'value' => 'Tbfunction::view_user($data->ORDERITEM_order_item_id)',
                	'htmlOptions'=>array('style'=>
                			'width: 10%;text-align:center')
                ),
      	    	array(
      	    		'value'=>'Tbfunction::review_order($data->ORDERITEM_order_item_id)',
      	    		'htmlOptions'=>array('style'=>
                			'width: 10%;text-align:center')
      	    	)
            );
      	   
        	//$this->widget('bootstrap.widgets.TbGridView', array(
      	    $this->widget('ext.groupgridview.GroupGridView', array(
        	//'type'=>'striped bordered condensed',
            'id' => 'order-grid',
            'dataProvider' => $data->search(),
            'filter' => $data,
            'columns' => $order_columns,
        	'mergeColumns' => array('order_detail')
        ));
        ?>

    </div>
</div>