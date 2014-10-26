<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/order.css"/>
</head>

<body>
<div class="tabs-container">
<ul class="tabs-nav">
    <li class="current ks-switchable-trigger-internal164"><a name="tab0">订单信息</a></li>
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
            <dt>备注：</dt>
            <dd>
                <?php
                echo $Order->memo;
                ?>
            </dd>
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
    <!--  
        <dt>发货时间：</dt>
        <dd>
            <?php
           // if($Order->ship_time){
            //    echo date("Y年m月d日 H:i:s",$Order->ship_time);
          //  }
            ?>
        </dd>
        -->

        <dt>付款时间：</dt>
        <dd>
            <?php
            if($Order->pay_time){
                echo date("Y年m月d日 H:i:s",$Order->pay_time);
            }
            ?>
        </dd>

        <dt>&nbsp;</dt>
        <dd>&nbsp;</dd>
    </dl>
    <div class="clearfix"></div>
</div>

<hr>
<div class="misc-info">
    <h3>订单详情</h3>
    <dl>
        <dt>订单状态：</dt>
        <dd>
            <?php
            echo Tbfunction::showStatus($Order->status);
            ?>
        </dd>
        <dt>支付状态：</dt>
        <dd>
            <?php
            echo Tbfunction::showPayStatus($Order->pay_status);
            ?>
        </dd></dl>
    <dl>
    <!--  
        <dt>发货状态：</dt>
        <dd>
            <?php
          //  echo Tbfunction::showShipStatus($Order->ship_status);
            ?>
        </dd>
        -->

        <dt>退款状态：</dt>
        <dd>
            <?php
            echo Tbfunction::showRefundStatus($Order->refund_status);
            ?>
        </dd>

        <dt>&nbsp;</dt>
        <dd>&nbsp;</dd>
    </dl>
    <div class="clearfix"></div>
</div>
<!-- 订单信息 -->
<table>
    <colgroup>
        <col class="item">
        <!-- <col class="sku">  -->
        <!-- 宝贝 -->

        <col class="status">
        <!-- 交易状态 -->

        <col class="service">
        <!-- 服务 -->

        <col class="adult_price">
        <col class="child_price">
        <!-- 单价（元） -->

        <col class="adult_number">
        <col class="child_number">
        
        <!-- 数量 -->

        <col class="discount">
        <!-- 优惠 -->

        <col class="order-price">

        <!-- 合计（元） -->
        <!-- 买/卖家信息 -->
    </colgroup>
    <tbody class="order">
    <tr class="sep-row">
        <td colspan="8"></td>
    </tr>
    <tr class="order-hd">
        <th class="item " style="width:31%">旅游产品</th>
                         <!--    <th class="sku" style="width:24%">宝贝属性</th> -->
                           <th class="adult_price" style="width:15%">成人(元)</th>
                           <th class="adult_number" style="width:15%">成人数量</th>
                           <th class="child_price" style="width:15%">儿童(元)</th>
                           <th class="child_number" style="width:15%">儿童数量</th>
                           <th class="order-price last" style="width:15%">产品总价(元)</th>
    </tr>

    <?php
    foreach($Order_item as $orderItems){

        ?>
        <tr class="order-item">
            <td class="item">
                <div class="pic-info">
                    <div class="pic s50">
                        <a target="_blank" href="javascript:void(0)" title="商品图片">
                            <img alt="查看产品详情" src="<?php echo Yii::app()->baseUrl. $orderItems->pic ?>" />
                        </a>
                    </div>
                </div>
                <div class="txt-info">
                    <div class="desc">
                        <span class="name"><a href="#" title="" target="_blank"><?php echo $orderItems->title ?></a></span>
                        <br>
                    </div>
                </div>
            </td>

            <td class="adult_price">
                <?php
                echo $orderItems->adult_price;
                ?>
            </td>
            
            <td class="adult_number">
                <?php
                echo $orderItems->adult_number;
                ?>
            </td>
            
            <td class="child_price">
                <?php
                echo $orderItems->child_price;
                ?>
            </td>

             <td class="child_number">
                <?php
                echo $orderItems->child_number;
                ?>
            </td>
            <td class="order-price" rowspan="1">
                <?php
                echo $orderItems->total_price;
                ?>
                <!--  
                <li>
                    (快递: <?php //echo $Order->ship_fee;?>)
                </li>
                -->
            </td>
        </tr>

        <?php
    }
    ?>
    <tr class="order-ft">
        <td colspan="8">
            <div class="get-money" colspan="6">
                <br>
                实付款：
                <strong>
                    <?php
                    echo $Order->pay_fee;
                    ?>
                </strong>元
                <br>
            </div>
        </td>
    </tr>
    </tbody>

</table>
</div>
</div><!-- end order-info -->

</body>
</html>
