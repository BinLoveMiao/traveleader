<?php
$this->breadcrumbs = array(
    '我的订单' => array('admin'),
    '管理',
);
?>

<div class="box">
    <div class="box-title">管理订单</div>
    <div class="box-content clearfix">
      <?php
      	    $order_columns=array(
                'order_id',
                //array(
                //    'name' => 'status',
                //    'value' => 'Tbfunction::showOrderStatus($data->status)',
               //     'filter' => Tbfunction::ReturnOrderStatus(),
                //),
      	    	array(
      	    			'name' => 'create_time',
      	    			'value' => 'date("Y-m-d", $data->create_time)',
      	    	),
                'feature_item_name',
                'total_fee',
                'pay_fee',

                array(
                    'name' => 'status',
                   'value' => 'Tbfunction::showOrderStatus($data->status)',
                    'filter' => Tbfunction::ReturnOrderStatus(),
                ),
                array(
                    'name' => 'review_status',
                    'value' => 'Tbfunction::showReviewStatus($data->review_status)',
                    'filter' => Tbfunction::ReturnReviewStatus(),
                ),
                array(
                    'value' => 'Tbfunction::view_user($data->order_id)',
                ),			
            );
      	    //if($model->status == "8"){// For test
      	    //if($model->status == "8" ){ 
      	    	$order_columns[]=array('value'=>'Tbfunction::review_order($data->order_id)');
      	    //}
        	$this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'order-grid',
            'dataProvider' => $model->MyOrderSearch(),
            'filter' => $model,
            'columns' => $order_columns,
        ));
        ?>

    </div>
</div>