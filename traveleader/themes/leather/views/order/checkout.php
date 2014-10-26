<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/cart/core.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/cart/box.css');
$this->breadcrumbs = array(
    '购物车' => array('/cart'),
    '确认订单'
);
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<script>
    $(function(){
        var flag = 0;
        $("#confirmOrder").click(function () {
            if ($(this).hasClass('btn1')) {
                $("#orderForm").submit();
            }
        });
        $('.delivery-address').change(function(){
             if($(this).val()){
                 if($('[name="payment_method_id"]').prop('checked')){
                     $('#confirmOrder').removeClass("btn");
                     $('#confirmOrder').addClass("btn1");
                 }
             }else{
                 $('#confirmOrder').removeClass("btn1");
                 $('#confirmOrder').addClass("btn");
             }
        })
        $('[name="payment_method_id"]').change(function(){
            if($(this).val()){
                if($('.delivery-address').prop('checked')){
                    $('#confirmOrder').removeClass("btn");
                    $('#confirmOrder').addClass("btn1");
                }
            }else{
                $('#confirmOrder').removeClass("btn1");
                $('#confirmOrder').addClass("btn");
            }
        })
    });

</script>
    <div style="margin-top:10px"></div>
<?php echo CHtml::beginForm(array('/order/create'), 'POST', array('id' => 'orderForm')) ?>
<?php if (Yii::app()->user->id) { ?>
    <div class="box address-panel">
        <div class="box-title container_24"><span
                style="float:right"><?php echo CHtml::link('联系人不在列表中? 添加新联系人', array('/member/delivery_address/admin'),array('target'=>'_blank')) ?></span>联系人
        </div>
        <div class="box-content">
            <?php
            $cri = new CDbCriteria(array(
                'condition' => 'user_id = ' . Yii::app()->user->id
            ));
            $AddressResult = AddressResult::model()->findAll($cri);
            if ($AddressResult) {
                foreach ($AddressResult as $address) {
                    $default_address = $address->is_default == 1 ? 'default_address' : '';
                    echo '<li class=' . $default_address . '>' . CHtml::radioButton('delivery_address', $address->is_default == 1 ? TRUE : FALSE, array('value' => $address->contact_id, 'class' => 'delivery-address', 'id' => 'delivery_address' . $address->contact_id));
                    echo CHtml::tag('span', array(
                            'class' => 'buyer-address shop_selection'),
                        $address->s->name . '&nbsp;' . $address->c->name . '&nbsp;' . $address->d->name . '&nbsp;' . $address->address . '&nbsp;(' . $address->contact_name . '&nbsp;)&nbsp;' . $address->mobile_phone .', ' . $address->email);
                    echo '</li>';
                }
            } else {

            ?>
            <div>
                <?php echo CHtml::link('请添加联系人', array('/member/delivery_address/create'),array('target'=>'_blank')) ?>
            </div>
            <?php } ?>
        </div>
    </div>

<?php } else { ?>
    <div class="box">
        <div class="box-title">联系人：</div>
        <div class="box-content">
            <?php $model = new AddressResult;
            ?>

            <div style="width:600px">

                <p class="note">带<span class="required">*</span>必须填写！</p>
<!--                <form role="form" class="form-horizontal"id="addr-form">-->
                    <div class="form-group">
                        <label for="AddressResult_contact_name" class="col-xs-2 control-label">联系人：<span class="required">*</span></label>
                        <div class="col-xs-10">
                        <input class="form-control" name="AddressResult[contact_name]" id="AddressResult_contact_name"
                               type="text"/>
                        </div>
                    </div>
                    <div class="form-group" style="height:40px; overflow:hidden;border:1px solid white">
                        <lable class="col-xs-2 control-lable" style="width:120px;padding-top:10px;"><b>所在地区：</b><span class="required">*</span></lable>
                               <div style="width:480px;">
                            <div class="row" data-url="<?php echo Yii::app()->createUrl('order/getChildAreas'); ?>">
                                <?php
                                $state_data = Area::model()->findAll("grade=:grade",
                                    array(":grade" => 1));
                                $state = CHtml::listData($state_data, "area_id", "name");
                                $s_default = $model->isNewRecord ? '' : $model->state;
                                echo '&nbsp;' . CHtml::dropDownList('AddressResult[state]', $s_default, $state,
                                        array(
                                            'empty' => '请选择省份',
                                            'ajax' => array(
                                                'type' => 'GET', //request type
                                                'url' => CController::createUrl('dynamiccities'), //url to call
                                                'update' => '#AddressResult_city', //selector to update
                                                'data' => 'js:"AddressResult_state="+jQuery(this).val()',
                                            )));
                                //empty since it will be filled by the other dropdown
                                $c_default = $model->isNewRecord ? '' : $model->city;
                                if (!$model->isNewRecord) {
                                    $city_data = Area::model()->findAll("parent_id=:parent_id",
                                        array(":parent_id" => $model->state));
                                    $city = CHtml::listData($city_data, "id", "name");
                                }
                                $city_update = $model->isNewRecord ? array() : $city;
                                echo '&nbsp;&nbsp;' . CHtml::dropDownList('AddressResult[city]', $c_default, $city_update,
                                        array(
                                            'empty' => '请选择城市',
                                            'ajax' => array(
                                                'type' => 'GET', //request type
                                                'url' => CController::createUrl('dynamicdistrict'), //url to call
                                                'update' => '#AddressResult_district', //selector to update
                                                'data' => 'js:"AddressResult_city="+jQuery(this).val()',
                                            )));
                                $d_default = $model->isNewRecord ? '' : $model->district;
                                if (!$model->isNewRecord) {
                                    $district_data = Area::model()->findAll("parent_id=:parent_id",
                                        array(":parent_id" => $model->city));
                                    $district = CHtml::listData($district_data, "id", "name");
                                }
                                $district_update = $model->isNewRecord ? array() : $district;
                                echo '&nbsp;&nbsp;' . CHtml::dropDownList('AddressResult[district]', $d_default, $district_update,
                                        array(
                                            'empty' => '请选择地区',
                                        )
                                    );
                                ?>
                                </div>
                                </div>
                               </div>

					
					<!--  
                    <div class="form-group" style="height:35px; border:1px solid white">
                       	
                        <label for="AddressResult_zipcode" class=" col-xs-2 control-label">邮政编号 <span class="required">*</span></label>
                         <div class="col-xs-10">
                         <input
                            name="AddressResult[zipcode]" id="AddressResult_zipcode"class="form-control"  type="text"/>
                         </div>
                    </div>
                    <div class="form-group" style="height:35px; border:1px solid white">
                        <label for="AddressResult_address" class="col-xs-2 control-label">详细地址 <span class="required">*</span></label>
                         <div class="col-xs-10">
                         <input
                            name="AddressResult[address]" id="AddressResult_address" type="text" class="form-control" />
                            </div>
                    </div> -->

                    <div class="form-group" style="height:35px;border:1px solid white">

                        <label for="AddressResult_mobile_phone" class="col-xs-2 control-label">手机 <span class="required">*</span></label>
                        <div class="col-xs-10">
                        <input  name="AddressResult[mobile_phone]" id="AddressResult_mobile_phone" class="form-control"
                               type="text"/>
                               </div>
                    <div class="form-group" style="height:35px;border:1px solid white">

                        <label for="AddressResult_email" class="col-xs-2 control-label">电子邮件 <span class="required">*</span></label>
                        <div class="col-xs-10">
                        <input  name="AddressResult[email]" id="AddressResult_email" class="form-control"
                               type="text"/>
                               </div>
                    </div>
                    <div class="form-group" style="height:35px;border:1px solid white">
                        <label for="AddressResult_phone" class="col-xs-2 control-label">电话</label>
                         <div class=" col-xs-10">
                         <input   name="AddressResult[phone]" class="form-control"
                                                                           id="AddressResult_phone" type="text"/></div>
                          </div>
<!--                    <div class="form-group" >-->
<!--                        <label for="AddressResult_memo" class="col-xs-2 control-label">备注</label>-->
<!--                        <div class=" col-xs-10">-->
<!--                        <textarea rows="6" cols="50" name="AddressResult[memo]" class="form-control"-->
<!--                                                                             id="AddressResult_memo"></textarea></div>-->
<!--                         </div>-->


                </div>
<!--         </form>-->
        </div>
    </div>

<?php } ?>
    <div class="box">
        <div class="box-title container_24">支付方式</div>
        <div class="box-content" style="vertical-align:middle;">
            <?php
                      $cri = new CDbCriteria(array(
                          'condition' => 'enabled = 1'
                      ));
                      $paymentMethod = PaymentMethod::model()->findAll($cri);
                      $list = CHtml::listData($paymentMethod, 'payment_method_id', 'name');
                      echo CHtml::radioButtonList('payment_method_id', '0', $list);
                      ?>
        </div>
    </div>

    <?php $imageHelper=new ImageHelper(); ?>
    <div class="box">
        <div class="box-title container_24">商品列表</div>
        <div class="box-content cart container_24">
            <table id="list-div-box" class="table">
                <tr style="background:#F3F3F3;">
                    <th class="col-xs-3">图片</th>
                    <th class="col-xs-3">名称</th>
                    <!--  <th class="col-xs-3">属性</th>-->
                    <th class="col-xs-1">价格</th>
                    <th class="col-xs-1">数量</th>
                    <th class="col-xs-1">小计</th>
                </tr>
                <?php
                $cart = Yii::app()->cart;
                if (isset($item)) {
                    $item->getId();
                    if($keys==null)
                    {
                        echo CHtml::hiddenField('sku_id', $item->sku->sku_id);
                        echo CHtml::hiddenField('item_id', $item->item_id);
                        //echo $item->sku->item_id;
                        //echo $item->item_id;
                        echo CHtml::hiddenField('quantity', $item->getQuantity());
                        echo CHtml::hiddenField('adult_number', $item->getAdultNumber());
                        echo CHtml::hiddenField('child_number', $item->getChildNumber());
                        echo CHtml::hiddenField('child_price', $item->getChildPrice());
                        echo CHtml::hiddenField('adult_price', $item->getAdultPrice());
                    }
                    ?>
                    <tr><?php
                        if($item->getMainPic()){
                            $picUrl=$imageHelper->thumb('58','58',$item->getMainPic());
                        ?>
                        <td><?php echo CHtml::image(Yii::app()->baseUrl. $picUrl, $item->title, array('width' => '60px', 'height' => '60px'));
                            } else {
                                echo Yii::t('leather','该产品没有上传图片');
                            } ?></td>
                        <td><?php echo $item->title; ?></td>
                        <!-- <td><?php echo  empty($item->sku) ? '' : implode(';', json_decode($item->sku->props_name, true)); ?></td> -->
                        <td>成人：<?php echo $item->getAdultPrice(); ?> <br>儿童：<?php echo $item->getChildPrice();?></td>
                        <td>成人：<?php echo $item->getAdultNumber(); ?> <br>儿童：<?php echo $item->getChildNumber(); ?> </td>
                        <td><?php echo $item->getSumPrice() ?>元</td>
                        <?php $price += $item->getSumPrice() ?>
                    </tr>
                <?php
                } else {

                    $items = $cart->getPositions();
                    if (empty($items)) {
                        ?>
                        <tr>
                            <td colspan="6" style="padding:10px">您的购物车是空的!</td>
                        </tr>
                    <?php
                    } else {
                        $price = 0;
                        foreach ($keys as $key) {
                            if (!isset($items[$key])) continue;
                            $item = $items[$key];
                            echo CHtml::hiddenField('keys[]', $key);
                            ?>
                            <tr><?php
                                ?>
                                <td><?php
                                    $picUrl=$imageHelper->thumb('58','58',$item->getMainPic());
                                    echo CHtml::image($picUrl, $item->title, array('width' => '70px', 'height' => '70px')); ?></td>
                                <td><?php echo $item->title; ?></td>
                               <!--  <td><?php echo empty($item->sku) ? '' : implode(';', json_decode($item->sku->props_name, true)); ?></td> -->
                                 <td>成人：<?php echo $item->getAdultPrice(); ?> <br>儿童：<?php echo $item->getChildPrice();?></td>
                       			 <td>成人：<?php echo $item->getAdultNumber(); ?> <br>儿童：<?php echo $item->getChildNumber(); ?> </td>
                        		<td><?php echo $item->getSumPrice() ?>元</td>
                                <?php $price += $item->getSumPrice() ?>
                            </tr>
                        <?php
                        }
                    }
                }?>
                <tr>
                    <td colspan="6" style="padding:10px;text-align:right">总计：<?php echo $price; ?> 元</td>
                </tr>
            </table>

        </div>
        <div class="box-content">
            <div class="memo" style="float:left"><h3>
                    给我们留言：</h3>
                    <textarea id="memo" name="memo" placeholder="选填，可以告诉卖家您对商品的特殊要求，如：需要接送等" rows="5"></textarea>
            </div>
        </div>

            <div><button id="checkout" class="btn btn-danger pull-right" style="line-height:20px;margin-right:150px;margin-bottom:30px;" href=""
                <?php if(!$AddressResult&&Yii::app()->user->id) {
                    echo "disabled=true";
                }?>>确认订单</button></div>




    </div>


<?php echo CHtml::endForm() ?>
<script type="text/javascript">
    $(function() {
        if($("input:radio[name='delivery_address']").is(":checked")) {
            $("#checkout").removeAttr('disabled');
        } else {
            $('input:radio:first').attr('checked', true);
        }
    });
    $('#AddressResult_state, #AddressResult_city').change(function() {
        var url = $(this).parent('.row').data('url');
        var select = '';
        if (this.id == 'AddressResult_state') {
            select = '#AddressResult_city';
        } else {
            select = '#AddressResult_district';
        }
        $.get(url,{'parent_id': $(this).val()},function(response){
            var html = '';
            for (var i in response) {
                var option = '<option value="'+i+'">'+response[i]+'</option>';
                html += option;
            }
            $(select).html(html);
        },'json');
    });
</script>