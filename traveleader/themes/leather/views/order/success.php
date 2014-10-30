<?php
$this->breadcrumbs = array(
    '购物车' => array('/cart'),
    '订单成功',
);
?>
<div class="box" style="width: 1180px; margin: 10px auto;">
    <div class="box-title">订单成功</div>
    <div class="box-content">
       	 恭喜你！订单成功，
       	 <?php
       	 ?>
       	 <a href="
       	 <?php if(!Yii::app()->user->isGuest) 
       	 	echo Yii::app()->getBaseUrl(true). '/member/orderlist/detail-'.$order_id;
       	 	else echo Yii::app()->createUrl('order/view?id='. $order_id);
       	 ?>">
       	 <span>请点击查看订单。<br/></span>
		 </a>
    </div>
</div>