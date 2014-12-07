<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/order.css"/>
</head>

<body>
<div class="tabs-container">
<ul class="tabs-nav">
    <li class="current ks-switchable-trigger-internal164"><a name="tab0">订单项目信息</a></li>
</ul>

<div class="tabs-panels">
<div class="info-box order-info ks-switchable-panel-internal165" style="display: block;">
<h2>订单信息</h2>
<div>
    <div class="addr_and_note">
        <dl>
            <dt>
                联系人：
            </dt>
            <dd>
                <?php
                echo $Order->receiver_name.' ，'.$Order->receiver_mobile.' ，';
                echo Order::model()->showDetailAddress($Order);
                ?>
            </dd>
            <!--  
            <dt>备注：</dt>
            <dd>
                <?php
                //echo $Order->memo;
                ?>
            </dd>-->
        </dl>
    </div>

<hr>
<!-- 订单信息 -->
<div class="misc-info">
    <h3>订单信息</h3>
    <dl>
        <dt>订单编号：</dt>
        <dd>
            <?php
            echo $Order->order_id;
            ?>
        </dd>
        <dt>成交时间：</dt>
        <dd>
            <?php
            if($Order->create_time){
                echo date("Y年m月d日 H:i:s",$Order->create_time);
            }
            ?>
        </dd></dl>
    <dl>

        <dt>付款时间：</dt>
        <dd>
            <?php
            if($Order->pay_time){
                echo date("Y年m月d日 H:i:s",$Order->pay_time);
            }
            ?>
        </dd>
        
         <dt>出游时间：</dt>
        <dd>
            <?php
            //if(count($Order_item) != 0){
             //   $travel_date=$Order_item[0]->travel_date;
                echo $order_item->travel_date;
           // }
			//$gap=ceil((strtotime(date("Y-M-d h:i:s")) - strtotime($travel_date. ' 00:00:00'))/86400);
			//if($gap > $Order->whole_num_days){
			?> 
			<!--  
				<div class="post_note">
				<a href=""> 发表游记</a> 
				</div>
				<div class="post_review">
				<a href=""> 发表评论</a> 
				</div>
			<?php	
			//}
            ?>-->

        </dd>

        <dt>&nbsp;</dt>
        <dd>&nbsp;</dd>
    </dl>
    <div class="clearfix"></div>
</div>

<hr>
<div class="misc-info">
    <h3>订单项目详情</h3>
    <dl>
        <dt>订单状态：</dt>
        <dd>
            <?php
            echo Tbfunction::showOrderStatus($order_item->status);
            ?>
        </dd>
        <!--  
        <dt>支付状态：</dt>
        <dd>
            <?php
            //echo Tbfunction::showPayStatus($Order->pay_status);
            ?>
        </dd>-->
        </dl>
    <dl>
    <!--  
        <dt>发货状态：</dt>
        <dd>
            <?php
          //  echo Tbfunction::showShipStatus($Order->ship_status);
            ?>
        </dd>
        -->
		<!-- 
        <dt>退款状态：</dt>
        <dd>
            <?php
            //echo Tbfunction::showRefundStatus($Order->refund_status);
            ?>
        </dd>-->

        <dt>&nbsp;</dt>
        <dd>&nbsp;</dd>
    </dl>
    <div class="clearfix"></div>
</div>
<!-- 订单信息 -->

<dl>
   <dt>订单项目清单：：</dt>
   <dd>

<table>
    <colgroup>
        <col class="item">
        <!-- <col class="sku">  -->
        <!-- 宝贝 -->
        <col class="price">
        <!-- 单价（元） -->

        <col class="number">
        
        <!-- 数量 -->

        <col class="discount">
        <!-- 优惠 -->

        <col class="order-price">

        <!-- 合计（元） -->
        <!-- 买/卖家信息 -->
    </colgroup>
    <tbody class="order">
    <tr class="sep-row">
        <td colspan="1"></td>
    </tr>
    <tr class="order-hd">
        <th class="item " style="width:30%">旅游产品</th>
                           <th class="price" style="width:10%">价格(元)</th>
                           <th class="num" style="width:10%">人数</th>
                           <th class="order-price last" style="width:20%">产品总价(元)</th>
    </tr>

        <tr class="order-item">
            <td class="item">
                <div class="pic-info">
                    <div class="pic s50">
                        <a target="_blank" href="javascript:void(0)" title="商品图片">
                            <img alt="查看产品详情" src="<?php echo Yii::app()->baseUrl. $order_item->pic ?>" />
                        </a>
                    </div>
                </div>
                <div class="txt-info">
                    <div class="desc">
                        <span class="name"><a href="<?php echo Yii::app()->createUrl('item/view', array('id' => $order_item->item_id));?>" 
                        	title="" target="_blank"><?php echo $order_item->title ?></a></span>
                        <br>
                    </div>
                </div>
            </td>

            <td class="price" style="width:10%">
            	<p>成人：<?php echo $order_item->adult_price;?></p>
				<p>儿童：<?php echo $order_item->child_price;?></p>
            </td>
            
            <td class="num">
            	<p>成人：<?php echo $order_item->adult_number;?> </p>
                <p>儿童：<?php echo $order_item->child_number;?></p>
            </td>
            
            <td class="order-price" rowspan="1">
                <?php
                echo $order_item->total_price;
                ?>
            </td>
        </tr>
   </table>
   
   <table>
        <tr class="sched-hd">
        	<th class="sched_time " style="width:6%">时间</th>
            <th class="sched_detail" style="width:35%">行程安排</th>
            <th class="sched_meal" style="width:15%">餐饮</th>
            <th class="sched_accom" style="width:22%">住宿</th>
            <th class="sched_notice" style="width:22%">注意事项</th>
    	</tr>
    	

        <?php
        $schedules = Schedule::model()->findAllByAttributes(array('item_id' => $order_item->item_id));
        foreach($schedules as $sched){
			$time_detail=$sched->decodeSchedule();
		?>
		<tr class="sched_item">
			<td class="sched_time">
                <span>第<?php
                echo $sched->which_day;
                ?>天</span>
            </td>
            
            <td class="sched_detail">
            	<?php 
            		foreach($time_detail as $detail){
						?>
						<span><?php if($detail['time']) echo $detail['time']."："?></span>
						<span><?php echo $detail['detail']?><br></span>
						<?php
					}
            	?>
            </td>
            
            <td class="sched_meal">
                <?php
                echo $sched->meal;
                ?>
            </td>
            
            <td class="sched_accom">
                <?php
                echo $sched->accommodation;
                ?>
            </td>
            
            <td class="sched_notice">
                <?php
                echo $sched->notice;
                ?>
            </td>          
		</tr>
		<?php 
   		}
    ?>
    <!--  
    <tr class="order-ft">
        <td colspan="8">
            <div class="get-money" colspan="6">
                <br>
                实付款：
                <strong>
                    <?php
                   // echo $Order->pay_fee;
                    ?>
                </strong>元
                <br>
            </div>
        </td>
    </tr>-->
    </tbody>

</table>
</dd>
</dl>
</div>
</div><!-- end order-info -->

</body>
</html>
