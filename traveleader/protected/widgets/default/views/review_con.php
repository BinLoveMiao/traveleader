<li class="tb-r-review">
	<dl class="clearfix">
    <!--<div class="tb-r-buyer">  -->
        <!--  <div class="tb-r-b-photo"><img src="#"></div>-->
        <dt>
        <?php $customer = User::model()->find(array(
                'select' => 'username,pic',
                'condition' => 'id=?',
                'params' => array($reviewData->customer_id)
            ));
        ?>
        <div class="tb-r-b-photo">
        <img src=<?php if($customer['pic']) echo Yii::app()->baseUrl.$customer['pic'];
        	else echo Yii::app()->baseUrl.'/upload/user/default.png';?>
        	height="65" width="65">
        </div>
        <p class="tb-r-b-user">
        	<?php
        	if($customer['username']){ 
            	echo ($customer['username']);
            }
            else{
				echo 'anonymous';
			}
            ?>
        </p>
        </dt>
   <!--  </div> -->

        <dd>
        <div class="tb-r-cnt" >
        	<p class="clists_words clearfix" style="background:#F3F3F3;" >
        	<span>导游服务
        	<em><?php 
        		if($reviewData->guide_rating == 1){
					echo '赞';
				}
				else if($reviewData->guide_rating == 2){
					echo '一般';
				}
				else if($reviewData->guide_rating == 3){
					echo '踩';
				}
        		?></em></span>
        		
        	<span>行程安排
        	<em><?php 
        		if($reviewData->schedule_rating == 1){
					echo '赞';
				}
				else if($reviewData->schedule_rating == 2){
					echo '一般';
				}
				else if($reviewData->schedule_rating == 3){
					echo '踩';
				}
        		?></em></span>
        		
        	<span>餐饮住宿
        	<em><?php 
        		if($reviewData->meal_rating == 1){
					echo '赞';
				}
				else if($reviewData->meal_rating == 2){
					echo '一般';
				}
				else if($reviewData->meal_rating == 3){
					echo '踩';
				}
        		?></em></span>
        		
        	<span>交通出行
        	<em><?php 
        		if($reviewData->transport_rating == 1){
					echo '赞';
				}
				else if($reviewData->transport_rating == 2){
					echo '一般';
				}
				else if($reviewData->transport_rating == 3){
					echo '踩';
				}
        		?></em></span>
        	</p>
        	
            <p class = "comment_detail">
                <?php print_r($reviewData->content); ?>
            </p>

            <?php if($reviewData->guide_review){?> 
            <p class = "comment_1">   
            	<span>导游服务：</span>
            	<?php print_r($reviewData->guide_review); ?>
            </p>
            
            <?php } if($reviewData->schedule_review){?>
			<p class = "comment_2">   
            	<span>行程安排：</span><?php print_r($reviewData->schedule_review); ?>
            </p>
            
            <?php } if($reviewData->meal_review){?>
            <p class = "comment_3">   
            	<span>餐饮住宿：</span><?php print_r($reviewData->schedule_review); ?>
            </p>
            
            <?php } if($reviewData->transport_review){?>
            <p class = "comment_4">   
            	<span>交通出行：</span><?php print_r($reviewData->transport_review); ?>
            </p>
            <?php } ?>
            
            <dl class="comment_from">
            <dt>
                <?php echo date('Y-m-d H:i:s',$reviewData->create_at); ?>
            </dt>
            </dl>
        </div>
            
        </dd>
     </dl>
</li>
        
<?php
//$this->renderPartial('/review_reply_con',array(
//    'review_id'=>$reviewData->review_id,
//    'itemId'=>$itemId,
//    'username'=>$customer['username'],
//    'num'=>$num,
//    'i'=>$i,
//));
//echo "</dl>";
//echo " </li>";
?>