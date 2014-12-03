<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/slides.jquery.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/pptBox.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/MetroJs.js'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/MetroJs.css'); ?>

<?php
$imageHelper=new ImageHelper();
Yii::app()->plugin->render('Hook_Login');
?>

<div class="warp_contant">
    <div class="float">
        <div class="float_button">
            <a href="/basic/page/contact?key=help">联系<br/>在线客服</a>
        </div>
    </div>
    
    <div class="product_cate contaniner_24">
     <div class="product_cate_tit0"><label><?php echo "旅游标签";?></label></div>
     <div style="width: 840px; height: 350px; overflow: hidden; position: relative; 
     	margin-top: 20px; margin-left: 20px;"class="metro_tags">
    	 <ul id="metro_tags" class="tags">
     	 <?php
                    	$data_mode=array('carousel', 'slide', 'flip');
                    	$data_delay=array(2000,2500,3000);
                    	$data_dir=array('horizontal', 'vertical');
                    	$tag_index=array_rand($tags, min(array(10, count($tags))));
                    	foreach ($tag_index as $index) {
							$tag=$tags[$index];
							//echo $tag->name;
                    		$params['tag'] = $tag->id;
                    		if($rand_selector==3){
								$option=' data-direction='.$data_dir[rand(0, 1)];
							}
							else{
								$option='';	
							}
                    		echo '<a style="display:block" href="'.Yii::app()->createUrl('catalog/index', $params) .'">'. 
                    			'<div class="live-tile" data-mode='.$data_mode[rand(0, 2)].
                    			' data-delay='.$data_delay[rand(0, 2)].
                    			$option.
                    			'>' .
                    			'<span class="tile-title" style="background:#2D2D2D;">'. $tag->name. '</span>'.
                    			'<div><img class="full" src="'. Yii::app()->baseUrl. $tag->pic1.
                    						'" alt="1"'.'/></div>'.
                    			'<div><img class="full" src="'. Yii::app()->baseUrl. $tag->pic2.
                    						'" alt="2"'.'/></div>'.
                    			'<div><img class="full" src="'. Yii::app()->baseUrl. $tag->pic3.
                    						'" alt="3"'.'/></div>'.
                    			'<div><img class="full" src="'. Yii::app()->baseUrl. $tag->pic4.
                    						'" alt="4"'.'/></div>'.'</div>'.'</a>';
                    						
                    		//$pics=array($tag->pic1, $tag->pic2, $tag->pic3, $tag->pic4);
                    		//foreach(range(1, $tag->num_pics) as $i){
                    		//	$display=$display.'<div><img class="full" src="'. Yii::app()->baseUrl. $pics[$i-1].
                    		//			'" alt="'.$i.'"'.'/></div>';
							//}
                    		//$display=$dispaly. '</div>'.'</a>';
                    		//echo $display;
                    ?> 
   				 	<?php 
                    	}
                    ?> 
                    </ul>
     </div>
     </div>
     <!-- Activate live tiles -->
	<script type="text/javascript">
    	// apply regular slide universally unless .exclude class is applied 
    	// NOTE: The default options for each liveTile are being pulled from the 'data-' attributes
    	$(".live-tile, .flip-list").not(".exclude").liveTile();
	</script>
	
	<!--  
	<div style="width: 400px; height: 350px; overflow: hidden; position: relative;" class="weather">

	</div>
	-->
	
    <div class="warp_product">
        <?php $isFrist = true;
        $num = 0;
        foreach ($newItems as $category_name => $items) {
			//echo "Category_name = ".$category_name;
			//foreach($items as $it){
			//	echo "Item = :".$it->title;
			//}
            if ($isFrist) { ?>
                <div class="product_new contaniner_24">
                    <div class="product_new_tit"><label><?php echo $category_name; ?></label><a href="<?php echo Yii::app()->baseUrl.'/'.Menu::model()->getUrl($category_name).'&sort=newd';?>">更多新品>></a></div>
                    <div class="product_c">
                        <div class="product_list">
                            <?php
                            for ($i = 1; $i <= 4; $i++) {
                                $newItem = $items[$i];
                                $itemUrl = Yii::app()->createUrl('item/view', array('id' => $newItem->item_id));
                                ?>
                                <div class="product_d">
                                    <div class="product_img"><a href="<?php echo $itemUrl; ?>">
                                            <?php
                                                if( $newItem->getMainPic()){
                                                    $image=new ImageHelper();
                                                    $picUrl=$image->thumb('200','200', $newItem->getMainPic());
                                                    $picUrl=Yii::app()->baseUrl.$picUrl;
                                                }else $picUrl=$newItem->getHolderJs('200','200');
                                            ?>
                                            <img alt="<?php echo $newItem->title; ?>" src="<?php echo $picUrl; ?>"
                                                 width="200" height="200"></a>
                                    </div>
                                    <div class="product_name">
                                        <a href="<?php echo $itemUrl; ?>"><?php echo $newItem->title; ?></a>
                                    </div>
                                    <div class="product_price">
                                        <div class="product_price_n"><?php echo $newItem->currency . $newItem->price ?></div>
                                        <div class="product_price_v"><a href="<?php echo $itemUrl; ?>">详情点击</a></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
           <?php } else { ?>
                <div class="product_cate contaniner_24">
                    <div class="product_cate_tit<?php echo $num; ?>"><label><?php echo $category_name; ?></label><a href="<?php echo Yii::app()->baseUrl.'/'.Menu::model()->getUrl($category_name).'&sort=newd';?>">更多新品>></a></div>
                    <div class="product_ca">
                        <div class="product_list_ca">
                            <?php foreach ($items as $newItem) {
                                $itemUrl = Yii::app()->createUrl('item/view', array('id' => $newItem->item_id));
                                ?>
                                <div class="product_e">
                                    <div class="product_img"><a href="<?php echo $itemUrl; ?>">
                                            <?php
                                            if( $newItem->getMainPic()){
                                            $image=new ImageHelper();
                                            $picUrl=$image->thumb('200','200', $newItem->getMainPic());
                                            $picUrl=Yii::app()->baseUrl.$picUrl;
                                            }else $picUrl=$newItem->getHolderJs('200','200');
                                            ?>
                                            <img alt="<?php echo $newItem->title; ?>" src="<?php echo $picUrl; ?>"
                                                 width="200" height="200"></a>
                                    </div>
                                    <div class="product_name">
                                        <a href="<?php echo $itemUrl; ?>"><?php echo $newItem->title; ?></a>
                                    </div>
                                    <div class="product_price">
                                        <div
                                            class="product_price_n"><?php echo $newItem->currency . $newItem->price ?></div>
                                        <div class="product_price_v"><a href="<?php echo $itemUrl; ?>">详情点击</a></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php }
            $num++;
            $isFrist = false;
        } ?>
    </div>
</div>
<script type="text/javascript">
    //保证导航栏背景与图片轮播背景一起显示
//    $("#mainbody").removeClass();
//    $("#mainbody").addClass("index_bg01");
    $(function () {
        //滚动Banner图片的显示
        $('#slides').slidesjs({
            width: 940,
            height: 400,
            navigation: {
                active:true,
                effect:"fade"
            },
            effect:{
                fade:{
                    speed:200
                }
            },
            play: {
                active: true,
                // [boolean] Generate the play and stop buttons.
                // You cannot use your own buttons. Sorry.
                effect: "fade",
                // [string] Can be either "slide" or "fade".
                interval: 5000,
                // [number] Time spent on each slide in milliseconds.
                auto: true,
                // [boolean] Start playing the slideshow on load.
                swap: true,
                // [boolean] show/hide stop and play buttons
                pauseOnHover: false,
                // [boolean] pause a playing slideshow on hover
                restartDelay: 2500
                // [number] restart delay on inactive slideshow
            }
        });
    });
    function change_bg(n) {
        var tnum = $(".tab_t_list>li").length;
        for (i = 1; i <= tnum; i++) {
            if (i == n) {
                $("#pop_" + i).css("display", "");
                $(".tab_t_list>li")[i - 1].className = "current";
            } else {
                $("#pop_" + i).css("display", "none");
                $(".tab_t_list>li")[i - 1].className = "";
            }
        }
    }
</script>