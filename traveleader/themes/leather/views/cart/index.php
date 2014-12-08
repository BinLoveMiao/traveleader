<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/css/deal.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/cart/core.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/cart/box.css');
$this->breadcrumbs = array(
    '购物车',
);
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#updateCart").click(function (event) {
            $('#cartForm').submit();
        });
    });

</script>
<?php $imageHelper=new ImageHelper(); ?>
<div class="box">
    <div class="box-title container_24">我的购物车</div>
    <div class="box-content cart container_24">
        <?php echo CHtml::beginForm(array('/order/checkout'), 'POST', array('id' => 'cartForm')) ?>
        <table class="table" id="cart-table">
           <thead>
            <tr>
                <th class=""><?php echo CHtml::checkBox('checkAllPosition', true, array('data-url' => Yii::app()->createUrl('cart/getPrice'))); ?></th>
                <th class="col-md-2">图片</th>
                <th class="col-md-3">名称</th>
                <th class="col-md-1">出游日期</th>
                <th class="col-md-2">价格</th>
                <th class="col-md-2">出游人数</th>
                <th class="col-md-1">小计</th>
                <th class="col-md-1">操作</th>
            </tr>
            </thead>
            <?php
            //$cart = Yii::app()->cart;
            //$items = $cart->getPositions();
            if (empty($items)) {
                ?>
                <tr>
                    <td colspan="8" style="padding:10px">您的购物车是空的!</td>
                </tr>
            <?php
            } else {
                $total = 0;
                foreach ($items as $key => $item) {
//                    var_dump($key);die;
                    ?>
                    <tbody id="<?php echo $item->getId();?>"><tr><?php
                        $itemUrl = Yii::app()->createUrl('item/view', array('id' => $item->item_id));
                        ?>
                        <td style="display:none;">
                            <?php echo CHtml::hiddenField('item_id[]', $item->item_id, array('id' => '','class' => 'item-id'));
                            //echo CHtml::hiddenField('props[]', empty($item->sku) ? '' : implode(';', json_decode($item->sku->props, true)),  array('id' => '','class' => 'props'));?>
                        </td>
                        <td><?php echo CHtml::checkBox('position[]', true, array('value' => $key, 'data-url' => Yii::app()->createUrl('cart/getPrice'))); ?></td>
                        <?php
                            $picUrl=$imageHelper->thumb('70','70',$item->getMainPic());
                            $picUrl=yii::app()->baseUrl. $picUrl;
                        ?>
                        <td><a href="<?php echo $itemUrl; ?>"><?php echo CHtml::image($picUrl, $item->title, array('width' => '50%', 'height' => '60px')); ?></a></td>
                        <td><?php echo CHtml::link($item->title, $itemUrl); ?></td>
                        <td><p id="date"><?php echo $item->getDate(); ?></p></td>
                        <!--  
                        <td><?php //echo empty($item->sku) ? '' : implode(';', json_decode($item->sku->props_name, true)); ?></td>
                        -->
                        <td>
                        	<div>
                        		<p>成人: <span id="AdultPrice"><?php echo $item->getAdultPrice(); ?> </span>
                        		</p>
                        	</div>
                        	
                        	<div>
                        		<p>儿童: <span id="ChildPrice"><?php echo $item->getChildPrice(); ?></span>
                        		</p>
                        	</div>
                        	
                        </td>
                        <?php 
                       // $priceArr = array();
                        //$today =  date("Y-m-d");
                       // foreach($item_prices[$item->item_id] as $item_price){
                       // 	$days = round((strtotime($item_price->date)-strtotime($today))/3600/24);
                       // 	if( $days < 50){
                       // 		$priceArr[$item_price->item_price_id] =
                       // 		$item_price->date. " | "
                        //				.$item_price->price_adult . "/成 ". " ; "
                        //						.$item_price->price_child . "/儿";
                       // 	}
                      //  }
                        ?>
                        <!--  
                        <td>
                        <div class="deal_price_list">
                        <?php 
                        // echo CHtml::dropDownList('listname', $select,
            			//	$priceArr,
            			//	array('empty' => '请选择出行日期', 
						//		'id' => 'price_list'
						//	));
            			?>
            			</div>
                        </td>-->
                       
                        <td>
                        	<p>成人
                            <span class="glyphicon glyphicon-minus-sign btn-reduce"></span>
                            <?php echo CHtml::textField('quantity[]', $item->getAdultNumber(),
                            		array('size' => '4', 'class'=>'quantity','maxlength' => '5', 
									'data-url' => Yii::app()->createUrl('cart/update'))); ?>
							<!--
                            <input id="pre_quantity" class="pre_quantity" type="hidden" value="
                            <?php //echo $item->getQuantity();?>" />  -->
                            <span class="glyphicon glyphicon-plus-sign btn-add"></span>
                            </p>
                            
                            <p>儿童
                             <span class="glyphicon glyphicon-minus-sign btn-reduce2"></span>
                            <?php echo CHtml::textField('quantity2[]', $item->getChildNumber(),
                            		array('size' => '4', 'class'=>'quantity2','maxlength' => '5', 
									'data-url' => Yii::app()->createUrl('cart/update'))); ?>
                            <span class="glyphicon glyphicon-plus-sign btn-add2"></span>
                            </p>

                            <div id="stock-error"></div><input id="pre_quantity" type="hidden"  />
                        </td>


                        <td class="sum-price"><div id="SumPrice"><?php echo $item->getSumPrice(); ?></div>元</td>
                        <td><?php echo CHtml::link('移除', array('/cart/remove', 'key' => $item->getId())) ?></td>
                    </tr></tbody>
                    <?php $i++; $total += $item->getSumPrice();?>
                <?php
                }
            } ?>
            <tfoot>
            <tr>
                <td colspan="8" style="padding:10px;text-align:right">总计：<label id="total_price"><?php echo $total;?></label>元</td>
            </tr>
            <tr>
                <td colspan="8" style="vertical-align:middle">
                    <input class="btn btn-danger pull-left" type="button" value="清空购物车" onclick="window.location.href='<?php echo Yii::app()->createUrl('cart/clear');?>'"/>
<!--                    <button class="btn btn-danger pull-left">--><?php //echo CHtml::link('清空购物车', array('/cart/clear'), array('class' => 'btn1')) ?><!--</button>-->

             <button class="btn btn-success" style="float:right;padding:1px 10px;" id="checkout"><?php echo CHtml::link('结算','#', array('class' => 'btn1','id'=>'account')) ?></button>
                    <input class="btn btn-primary" style="float:right;padding:1px 10px;margin-right: 10px;"  id="btn-primary" type="button"
                           value="继续购物" onclick="javascript:history.back(-1);"/>
<!--                    <button class="btn btn-primary"-->
<!--                            style="float:right;padding:1px 10px;margin-right: 10px;"  id="btn-primary">--><?php //echo CHtml::link('继续购物', array('./'), array('class' => 'btn1')) ?><!--</button>-->
                </td>
            </tr>
            </tfoot>
        </table>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
      $(".btn-add").on('click',function(){
          var preQuantity = Number( $(this).siblings(".quantity").val());
          $(this).siblings(".quantity").val(preQuantity + 1); 
          if($(this).siblings("#stock-error").find("#num-error")){
          	$(this).siblings("#stock-error").find("#num-error").remove();
          }
          //$(this).siblings(".pre_quantity").val(Number( $(this).siblings(".pre_quantity").val())+1);
          //update($(this).siblings(".quantity"));
          updateAdultQuantity($(this).siblings(".quantity"));
      });
      $(".btn-reduce").on('click',function(){
          var curQuantity = Number( $(this).siblings(".quantity").val());
          $(this).siblings("#stock-error").find("#num-error").remove();
          if(curQuantity < 1){
              $(this).siblings(".quantity").val(1);
              //$(this).siblings(".pre_quantity").val(1);
              $(this).siblings("#stock-error").append("<div id=\"num-error\" style=\"color:red\">出游人数不能小于0</div>");
          }else{
             //$(this).siblings(".pre_quantity").val(change_quantity-1);
              $(this).siblings(".quantity").val(curQuantity-1);
              //update($(this).siblings(".quantity"));
              updateAdultQuantity($(this).siblings(".quantity"));
          }
      });
      $(".btn-add2").on('click',function(){
    	  var curQuantity = Number( $(this).siblings(".quantity2").val());
          $(this).siblings(".quantity2").val(curQuantity + 1);
          if($(this).siblings("#stock-error").find("#num-error")){
            	$(this).siblings("#stock-error").find("#num-error").remove();
          }
          //$(this).siblings(".pre_quantity2").val(Number( $(this).siblings(".pre_quantity2").val())+1);
          updateChildQuantity($(this).siblings(".quantity2"));
      });
      $(".btn-reduce2").on('click',function(){
          var curQuantity = Number( $(this).siblings(".quantity2").val());
          $(this).siblings("#stock-error").find("#num-error").remove();
          if(curQuantity < 1){
              $(this).siblings(".quantity2").val(0);
             //$(this).siblings(".pre_quantity").val(1);
              $(this).siblings("#stock-error").append("<div id=\"num-error\" style=\"color:red\">出游人数不能小于1</div>");
          }else{
              //$(this).siblings(".pre_quantity").val(change_quantity-1);
              $(this).siblings(".quantity2").val(curQuantity - 1);
              updateChildQuantity($(this).siblings(".quantity2"));
          }
      });
      //$('.deal_price_list').change(function(){
      	//window.alert($('#price_list :selected').text());
      //  var selectedValue = $('#price_list :selected').text();
      //  window.alert(selectedValue);
      //  var values = selectedValue.split(" | ")[1].split(" ; ");
      //  var adultPrice = Number(values[0].split("/")[0]);
      //  var childPrice = Number(values[1].split("/")[0]);   
     // });
  });

    $(function(){
        $('[name="position[]"]').change(function() {
            if($('[name="position[]"]:checked').length == 0) {
                $("#checkout").attr('disabled',true);
            } else {
                $("#checkout").removeAttr('disabled');
            }
        });
        $("#checkAllPosition").change(function() {
            if(!$("#checkAllPosition").attr('checked')) {
                $("#checkout").attr('disabled',true);
            } else {
                $("#checkout").removeAttr('disabled');
            }
        });
        $(".quantity").keyup(function() {
            var tmptxt = $(this).val();
            $(this).val(tmptxt.replace(/\D|^0/g, ''));
        }).bind("paste", function() {
                var tmptxt = $(this).val();
                $(this).val(tmptxt.replace(/\D|^0/g, ''));
            }).css("ime-mode", "disabled"); 

        $(".quantity2").keyup(function() {
            var tmptxt = $(this).val();
            $(this).val(tmptxt.replace(/\D|^0/g, ''));
        }).bind("paste", function() {
                var tmptxt = $(this).val();
                $(this).val(tmptxt.replace(/\D|^0/g, ''));
        }).css("ime-mode", "disabled");    
    });//输入验证，保证只有数字。

    function updateAdultQuantity(quantity){
        var tr = quantity.closest('tr');
    	var item_id = tr.find(".item-id").val();
        var child_num = tr.find(".quantity2").val();
        var child_price = tr.find("#ChildPrice").html();
    	var adult_num = quantity.val();
    	var adult_price = tr.find("#AdultPrice").html();
    	var date = tr.find("#date").html();
        //var adultPrice = Number(tr.find('#AdultPrice').text());
        //alert(adultPrice);
        var data = {'item_id': item_id, 'adult_num': adult_num, 'child_num': child_num, 
        		'adult_price': adult_price, 'child_price': child_price, 'date': date};
       	var sumPriceDom = tr.find("#SumPrice")
        //var sumPrice= parseFloat(sumPriceDom.text());
        //sumPrice += adultPrice;
       	//sumPriceDom.text(sumPrice);
       	$.post('/traveleader/cart/update', data, function (response) {
            tr.find("#error-message").remove();
            tr.find("#num-error").remove();
            if (!response) {
                //$(".shopping_car").find("span").html(cart-sumPrice/singlePrice+parseInt(qty.val()));
                //tr.find("#SumPrice").html(parseFloat(qty.val()) * parseFloat(singlePrice));
                sumPriceDom.text(parseFloat(child_num) * parseFloat(child_price) + 
                		parseFloat(adult_num) * parseFloat(adult_price));
                update_total_price();
            }

        });
   	}

    function updateChildQuantity(quantity){
    	var tr = quantity.closest('tr');
    	var item_id = tr.find(".item-id").val();
        var child_num = quantity.val();
        var child_price = tr.find("#ChildPrice").html();
    	var adult_num =  tr.find(".quantity").val();
    	var adult_price = tr.find("#AdultPrice").html();
    	var date = tr.find("#date").html();
        //var adultPrice = Number(tr.find('#AdultPrice').text());
        //alert(adultPrice);
        var data = {'item_id': item_id, 'adult_num': adult_num, 'child_num': child_num, 
        		'adult_price': adult_price, 'child_price': child_price, 'date': date};
       	var sumPriceDom = tr.find("#SumPrice")
        //var sumPrice= parseFloat(sumPriceDom.text());
        //sumPrice += adultPrice;
       	//sumPriceDom.text(sumPrice);
       	$.post('/traveleader/cart/update', data, function (response) {
            tr.find("#error-message").remove();
            tr.find("#num-error").remove();
            if (!response) {
                //$(".shopping_car").find("span").html(cart-sumPrice/singlePrice+parseInt(qty.val()));
                //tr.find("#SumPrice").html(parseFloat(qty.val()) * parseFloat(singlePrice));
                sumPriceDom.text(parseFloat(child_num) * parseFloat(child_price) + 
                		parseFloat(adult_num) * parseFloat(adult_price));
                update_total_price();
            }

        });
   	}

    function update(quantity) {
        var tr = quantity.closest('tr');
        var sku_id = tr.find("#position");
        var qty = quantity;
        var item_id = tr.find(".item-id");
        var props = tr.find(".props");
        var cart=parseInt($(".shopping_car").find("span").html());
        var sumPrice= parseFloat(tr.find("#SumPrice").html());
        var singlePrice=parseFloat( tr.find("#Singel-Price").html());
        var data = {'item_id': item_id.val(), 'props': props.val(), 'qty': qty.val(),'sku_id':sku_id.val()};
        $.post('/cart/update', data, function (response) {
            tr.find("#error-message").remove();
            tr.find("#num-error").remove();
            if (!response) {
                $(".shopping_car").find("span").html(cart-sumPrice/singlePrice+parseInt(qty.val()));
                tr.find("#SumPrice").html(parseFloat(qty.val()) * parseFloat(singlePrice));
                update_total_price();
            }
            tr.find("#stock-error").append(response);
            if(quantity.siblings('#stock-error').find("#error-message").text()) {
                quantity.val(Number(quantity.val())-1);
            }
        });
    }
    function update_total_price() {
        var positions = [];
        $('[name="position[]"]:checked').each(function () {
            positions.push($(this).val());
        });
        $.post('/traveleader/cart/getPrice', {'positions': positions}, function (data) {
            if (!data.msg) {
                $('#total_price').text(data.total);
            }
        }, 'json');
    }

</script>