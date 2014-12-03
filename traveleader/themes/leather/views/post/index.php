
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
     
     <?php if($scenery) {?>
     <div class = "mdd-title">
     	<span><?php echo $scenery->name;?> </span>
     </div>
     
     <div class = "want-been yahei">
     	<div class = "num-been">
     		<div class="num-count">
     			<span>有 <?php echo $scenery->num_travel?> 游客去过</span>
     		</div>
     	</div>       
	</div>
	<?php }?>
     

	<!--  
     <div class="p-content">

     	</div>
    -->

     	
</div>

 
<div class="p-content" >
     <?php if($sceneries){?>
     	<div class="m-rank">
     		<div class="hd">
     			<span><?php echo "热门目的地";?></span>
     		</div>
     		<div class="metro_tags">
    	 		<ul id="metro_tags" class="tags">
     	 		<?php
                    	$data_mode=array('carousel', 'slide', 'flip');
                    	$data_delay=array(2000,2500,3000);
                    	$data_dir=array('horizontal', 'vertical');
                    	//$tag_index=array_rand($tags, min(array(10, count($tags))));
                    	foreach ($sceneries as $sce) {
							//$tag=$tags[$index];
							//echo $tag->name;
                    		$params['scenery'] = $sce->id;
                    		if($rand_selector==3){
								$option=' data-direction='.$data_dir[rand(0, 1)];
							}
							else{
								$option='';	
							}
							$scenery_pics=$sce->getSceneryPictures(4);
                    		echo '<a style="display:block" href="'.Yii::app()->createUrl('post/index', $params) .'">'. 
                    			'<div class="live-tile" data-mode='.$data_mode[rand(0, 2)].
                    			' data-delay='.$data_delay[rand(0, 2)].
                    			$option.
                    			'>' .
                    			'<span class="tile-title" style="background:#2D2D2D;">'. $sce->name. '</span>'.
                    			'<div><img class="full" src="'. Yii::app()->baseUrl.$scenery_pics[0]->pic.
                    						'" alt="1"'.'/></div>'.
                    			'<div><img class="full" src="'. Yii::app()->baseUrl.$scenery_pics[1]->pic.
                    						'" alt="2"'.'/></div>'.
                    			'<div><img class="full" src="'. Yii::app()->baseUrl.$scenery_pics[2]->pic.
                    						'" alt="3"'.'/></div>'.
                    			'<div><img class="full" src="'. Yii::app()->baseUrl.$scenery_pics[3]->pic.
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
     <?php } 
     if($scenery){
     			?>
     <div class="first-screen clearfix">			
     	<div class="m-photo">
    	 	<img src=<?php echo Yii::app()->baseUrl.$scenery->main_pic;?> width="670" height=“360”>
    	 	<a class="btn-num" href="" target="_blank">
    		 共 <em><?php echo $num_pics;?></em>张图片
    	 	</a>
     	</div>
     	
     	<div class="p-aside">
     		<div class="m-box m-tags">
     			<div class="hd">
     				<span> <?php echo $scenery->name;?> 简介</span>
     			</div>
     			
     			<div class="bd">
     			   <span>最佳旅游季节</span>
     				<div class="t-info">
     					<p>
     						<span class="highlight"><?php echo $scenery->best_time;?></span>
     					</p>
     				</div>
     				
     				<span>气候</span>
     				<div class="t-info">
     					<p>
     						<span class="highlight"><?php echo $scenery->climate;?></span>
     					</p>
     				</div>
     				
     				<span>介绍</span>
     				<div class="t-info-l">	
     					<p>
     						<span class="highlight"><?php echo $scenery->intro;?></span>
     					</p>
     				</div>

     			</div>
     		</div>
     	</div>
     
     </div>
     		
     		
     <?php }?>
     
<script>
     			
</script>
     		
<div class="m-post">
     <div class="hd">
     	<ul>
     	<?php 
     		$sort_params=array('new', 'hot', 'best');
     		$sort_display=array('最新游记','最热游记','精品游记');
     		$sort_selector=0;
     		if($_GET['sort']=='hot') $sort_selector=1;
     		else if ($_GET['sort']=='best') $sort_selector=2;
     		for($i=0;$i<count($sort_params);$i++){
				if($i!=$sort_selector){
					echo '<li><a href="'.Yii::app()->createUrl('/post/index', array_merge($_GET,array('sort' => $sort_params[$i]))).
					'">'.$sort_display[$i]. '</a></li>';
				}
				else{
					echo '<li class="on"><a href="'.Yii::app()->createUrl('/post/index', array_merge($_GET,array('sort' => $sort_params[$i]))).
					'">'.$sort_display[$i]. '</a></li>';
				}
			}
     	?>
     	</ul>
     	<span class="r-extra">
     		<a class="btn-addPost" href="<?php 	
				echo Yii::app()->createUrl("/post/create", array_merge($_GET));
			?>">
     		<i></i>
     		发表新游记
     		</a>
     	</span>
     </div>	
     <div class="post-list">
    	<ul>
           <?php if($posts !== null){
               foreach($posts as $post){?>
                <?php
                   $status = intval($post->status);
                   if($status < 2 ){
                        continue;
                   }
                   ?>
            <li class="post-item clearfix"> 
                <div class="post-cover" >  <!--图片部分-->
                    <img width="215" height="135"  class="attachment-thumbnail wp-post-image" src=<?php echo $post->cover_pic;?> >
                </div>
                <div class="post-title yahei">
                	<h4><a href="<?php echo Yii::app()->createUrl('post/view', array('id' => $post->id))?>"
                		class="post-link"><?php echo $post->title;?></a>  </h4>
                </div>
                
                <div class="post-author">
                	<?php
                	
                	?>
                	<span>
                	<?php 
                	echo $post->author->username;
                	?>
                	发表于: <?php echo date('Y-m-d H:i:s',$post->update_time);?></span>
                </div>
                
                <div class="post-content">
                   <?php echo $post->summary;?>
                </div>
            </li>

            <?php }}?>
		</ul>
	</div>


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

</div> 


    <div  style="height:1840px;border-left:2px solid #ececec;padding:10px;width:24%;" class="pull-right">
        <div style="text-align:center"> <h4><b>最新发表</b></h4>
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