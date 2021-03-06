<?php
/**
 * Created by cangzhou.
 * email:wucangzhou@gmail.com
 * Date: 12/17/13
 * Time: 2:47 PM
 */

$review=$this->reviewData();
$reviewData=$review[0];
$reviewCount=count($reviewData);
$pages=$review[1];
$reviewNum=Review::model()->reviewSummary($this->_itemId,$this->_entityId,'1');
//$picReviewCount= Review::model()->reviewSummary($this->_itemId,$this->_entityId,'2');
if($reviewCount>=1){
    $positiveRate=$reviewNum[1]/$reviewCount;
    $neutralRate=$reviewNum[2]/$reviewCount;
    $negativeRate=$reviewNum[3]/$reviewCount;
}
else{
    $positiveRate=0;
    $neutralRate=0;
    $negativeRate=0;
}

?>
<div id="review" url="<?php echo Yii::app()->baseUrl?>" product_id="<?php echo $this->_itemId?>">
    <div class="mc">
        <div class="rate">
            <strong>
                <?php echo round($positiveRate * 100)?>
        <span>
            %
        </span>
            </strong>
            <br>
    <span>
    	    好评率
    </span>
        </div>
        <div class="percent">
            <dl>
                <dt>
                 	 <span class="review-exp-img">
                 	 	<img src=<?php echo Yii::app()->baseUrl. '/upload/expression/positive.jpg'?> alt="赞"/>
                 	  </span>
            <span>
                (<?php echo round($positiveRate * 100)?>%)
            </span>
                </dt>
                <dd>
                    <div style="width: <?php echo round($positiveRate * 100)?>%;">
                    </div>
                </dd>
            </dl>
            <dl>
                <dt>
                  	<span class="review-exp-img">
                 	 	<img src=<?php echo Yii::app()->baseUrl. '/upload/expression/neutural.jpg'?> alt="一般"/>
                 	  </span>
            <span>
                (<?php echo round($neutralRate * 100)?>%)
            </span>
                </dt>
                <dd class="d1">
                    <div style="width: <?php echo round($neutralRate * 100)?>%;">
                    </div>
                </dd>
            </dl>
            <dl>
                <dt>
                   	<span class="review-exp-img">
                 	 	<img src=<?php echo Yii::app()->baseUrl. '/upload/expression/negative.jpg'?> alt="踩"/>
                 	  </span>
            <span>
                (<?php echo round($negativeRate * 100)?>%)
            </span>
                </dt>
                <dd class="d1">
                    <div style="width: <?php echo round($negativeRate * 100)?>%;">
                    </div>
                </dd>
            </dl>
        </div>
        <?php if(!$this->_isOrderItem){?>
        <div class="rep_review">
        <p>出游归来可点评产品</p>
        <p class="btn_review">
        	<?php echo CHtml::link("发表点评", Yii::app()->createUrl('member/orderlist/admin'))?>
        </p>
        </div>
        <?php }?>
        <div class="clr"></div>
    </div>
    <?php
    $this->renderPartial('/review_head',array('product_id'=>$this->_itemId,'entity'=>$this->_entityId, 'ReviewNum'=>$reviewNum,'picReviewCount'=>$picReviewCount));
    echo '<div class="tb-revbd">';
    echo '    <ul>';
    if ($reviewCount >= 1) {
        $i=0;
        foreach ($reviewData as $reviewData) {
            $this->renderPartial('/review_con',array(
                'reviewData'=>$reviewData,
                'itemId'=>$this->_itemId,
                'i'=>$i,
            ));
            $i++;
        }
    }else {echo "无记录";}
    ?>
    </ul>
    <?php
      $this->widget('CLinkPager',array('pages'=>$pages));
?>
</div>
</div>