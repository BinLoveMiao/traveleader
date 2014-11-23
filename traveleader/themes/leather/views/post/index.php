
<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/css/post.css');
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/css/product.css');
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/MetroJs.js'); 
$cs->registerCssFile(Yii::app()->baseUrl . '/css/MetroJs.css'); 

$this->pageTitle = Yii::app()->name;
?>

<?php if(!empty($_GET['tag'])): ?>
<h1>Posts Tagged with <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php endif; ?>


<div class="p-top clearfix" >
     <div class="top-info clearfix">
     	<div class='crumb'>
            <a href="<?php echo Yii::app()->baseUrl; ?>">首页>></a>
            <?php foreach ($this->breadcrumbs as $breadcrumb) {
                echo '<a href="' . $breadcrumb['url'] . '">' . $breadcrumb['name'] . '</a>';
            } ?>
        </div>
     </div>
     
     <div class = "mdd-title">
     	<span><?php if($scenery) echo $scenery->name;?> </span>
     </div>
     
     <div class="product_cate_tit0"><label><?php echo "热门目的地";?></label></div>
     <div style="width: 720px; height: 350px; overflow: hidden; position: relative;" class="metro_tags">
    	 <ul id="metro_tags" class="tags">
     	 <?php
                    	$data_mode=array('carousel', 'slide', 'flip');
                    	$data_delay=array(2000,2500,3000);
                    	$data_dir=array('horizontal', 'vertical');
                    	//$tag_index=array_rand($tags, min(array(10, count($tags))));
                    	foreach ($sceneries as $scenery) {
							//$tag=$tags[$index];
							//echo $tag->name;
                    		$params['scenery'] = $scenery->id;
                    		if($rand_selector==3){
								$option=' data-direction='.$data_dir[rand(0, 1)];
							}
							else{
								$option='';	
							}
							$scenery_pics=$scenery->getSceneryPictures(4);
                    		echo '<a style="display:block" href="'.Yii::app()->createUrl('post/index', $params) .'">'. 
                    			'<div class="live-tile" data-mode='.$data_mode[rand(0, 2)].
                    			' data-delay='.$data_delay[rand(0, 2)].
                    			$option.
                    			'>' .
                    			'<span class="tile-title" style="background:#2D2D2D;">'. $scenery->name. '</span>'.
                    			'<div><img class="full" src="'. Yii::app()->baseUrl."/".$scenery_pics[0]->pic.
                    						'" alt="1"'.'/></div>'.
                    			'<div><img class="full" src="'. Yii::app()->baseUrl."/".$scenery_pics[1]->pic.
                    						'" alt="2"'.'/></div>'.
                    			'<div><img class="full" src="'. Yii::app()->baseUrl."/".$scenery_pics[2]->pic.
                    						'" alt="3"'.'/></div>'.
                    			'<div><img class="full" src="'. Yii::app()->baseUrl."/".$scenery_pics[3]->pic.
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
 
    <div class="box-content" >
        <div class="pull-left" style="height:1900px;width:75%;background:white;">

           <?php if($posts !== null){
               foreach($posts as $post){?>
                <?php
                   $status = intval($post->status);
                   if(Yii::app()->user->isGuest)
                   {
                       if($status < 2 )
                       {
                           continue;
                       }
                   }
                   ?>
            <div class="news-outside">   <!--第一个新闻-->
                <div class="col-xs-3 news-img" >  <!--图片部分-->
                    <img width="150" height="150"  class="attachment-thumbnail wp-post-image" src=<?php echo Yii::app()->baseUrl.$post->cover_pic;?> >
                </div>
                <div class="col-xs-9 nes-list">
                    <div class="col-xs-12">   <!--新闻标题-->
                        <h4><a href="<?php echo Yii::app()->createUrl('post/view', array('id' => $post->id))?>" class="news-link"><?php echo $post->title;?></a>  </h4>
                    </div>
                    <div class="col-xs-12 news-summary">    <!--摘要-->
                        <p><?php echo $post->summary;?><a href="<?php echo Yii::app()->createUrl('post/view', array('id' => $post->id))?>" class="news-link">阅读全文 >></a>
                        </p>
                        <p>发表于:<?php echo date('Y-m-d H:i:s',$post->update_time);?>, 标签：<?php echo $post->tags;?></p>
                    </div>
                </div>
                </div>
            <!--第一个新闻结束-->

            <?php }}?>

            <div class="page_p"><!--分页-->
                <?php if ($pager->pageCount > 1 ) {
                    if ($pager->currentPage == 0 ) {
                        echo '<span class="end"><a href="javascript:void(0)" class="page_p"><img alt="" src=""/>首页</a></a></span>';
                        echo '<span class="end"><a href="javascript:void(0)" class="page_p"><img alt="" src=""/>上一页</a></a></span>';
                    } else {
                        echo '<span><a href="' . Yii::app()->createUrl('post/index', array_merge($_GET, array('page' => 0))) . '" class="page_p"><img alt="" src=""/>首页</a></a></span>';
                        echo '<span><a href="' . Yii::app()->createUrl('post/index', array_merge($_GET, array('page' => $pager->currentPage))) . '" class="page_p"><img alt="" src=""/>上一页</a></a></span>';
                    }
                    for ($i = $pager->currentPage-5; $i < $pager->currentPage+6; $i++) {
                        if($i < 0)
                            continue;
                        if($i >= $pager->pageCount)
                            break;
                        $class = $i == $pager->currentPage ? 'current' : '';
                        echo '<span class="' . $class . '"><a href="' . Yii::app()->createUrl('post/index', array_merge($_GET, array('page' => $i+1))) . '">' . ($i+1) . '</a></span>';
                    }
                    if ($pager->currentPage == $pager->pageCount - 1 ) {
                        echo '<span class="end"><a href="javascript:void(0)" class="page_n"><img alt="" src=""/>下一页</a></a></span>';
                        echo '<span class="end"><a href="javascript:void(0)" class="page_n"><img alt="" src=""/>末页</a></a></span>';
                    } else {

                        echo '<span><a href="' . Yii::app()->createUrl('post/index', array_merge($_GET, array('page' => $pager->currentPage + 2))) . '" class="page_n"><img alt="" src=""/>下一页</a></a></span>';

                        echo '<span><a href="' . Yii::app()->createUrl('post/index', array_merge($_GET, array('page' => $pager->pageCount))) . '" class="page_n"><img alt="" src=""/>末页</a></a></span>';
                    }
                }
                ?>

            </div>

<!--            <div> <!--分页-->
<!--                <ul class="pagination pull-right" id="news-pag">-->
<!--                    <li><a href="#">&laquo;</a></li>-->
<!--                    <li><a href="#">1</a></li>-->
<!--                    <li><a href="#">2</a></li>-->
<!--                    <li><a href="#">3</a></li>-->
<!--                    <li><a href="#">4</a></li>-->
<!--                    <li><a href="#">5</a></li>-->
<!--                    <li><a href="#">&raquo;</a></li>-->
<!--                </ul>-->
<!---->
<!--            </div>-->
        </div>   <!--新闻列表-->



    <div  style="height:1840px;border-left:2px solid #ececec;padding:10px;width:24%;" class="pull-right">
        <div style="text-align:center"> <h4><b>热点追踪</b></h4>
        </div>
        <ul class=" pull-center" id="news-hot">
            <?php
            $num=0;
              foreach($posts as $post){
                  if($num==5){//限制显示热点新闻条数为5条
                      break;
                  }
               if($posts !== null)
               {
                   ?>
                   <?php
                   $status = intval($post->status);
                   if(Yii::app()->user->isGuest)
                   {
                       if($status < 2 )
                       {
                           continue;
                       }
                   }
                   ?>
            <li><a class="news-link "href="<?php echo Yii::app()->createUrl('post/view', array('id' => $post->id))?>"><?php echo $post->title;?></a></li>
            <?php $num++;}}?>
<!--            <li><a class="news-link" href="/basic/themes/leather/views/post/secondNews.html">如何用PhotoShop制作网站的favicon.ico </a></li>-->
<!--            <li><a class="news-link " href="/basic/themes/leather/views/post/thirdNews.html">	Web 开发者必备的 14 个 JavaScript 音频库</a></li>-->
<!--            <li><a class="news-link  "href="/basic/themes/leather/views/post/forthNews.html">	jquery ajax回调函数中调用$(this)的问题</a></li>-->
<!--            <li><a class="news-link  "href="">......</a></li>-->
<!--            <li><a  class="news-link " href="#">.....</a></li>-->
<!--            <li><a class="news-link " href="#">.....</a></li>-->
        </ul>
    </div>
     </div>