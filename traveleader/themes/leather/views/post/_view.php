<!--<div class="post">-->
<!--	<div class="post_title">-->
<!--		--><?php //echo CHtml::link(CHtml::encode($data->title), $data->getUrl()); ?>
<!--	</div>-->
<!--	<div class="author">-->
<!--		posted by --><?php //echo $data->author->username . ' on ' . date('F j, Y',$data->create_time); ?>
<!--	</div>-->
<!--	<div class="content">-->
<!--		-->
<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/css/post.css');
?>
<!--	</div>-->
<!--	<div class="post_nav">-->
<!--		<b>Tags:</b>-->
<!--		--><?php //echo implode(', ', $data->tagLinks); ?>
<!--		<br/>-->
<!--		--><?php //echo CHtml::link('Permalink', $data->getUrl()); ?><!-- |-->
<!--		--><?php //echo CHtml::link("Comments ({$data->commentCount})",$data->url.'#comments'); ?><!-- |-->
<!--		Last updated on --><?php //echo date('F j, Y',$data->update_time); ?>
<!--	</div>-->
<!--</div>-->

<div class="container_24">
    <div class="container" style="overflow: hidden">
        <div class="grid_18 alpha">
            <div id="content" style="background: #ffffff;padding: 20px;font-size: 14px;">
            	<div class="post-hd">
            		<div class="post-hd-wrap clearfix">
               			<div class='crumb'>
            				<a href="<?php echo Yii::app()->baseUrl; ?>">首页>></a>
            				<?php foreach ($this->breadcrumbs as $breadcrumb) {
            					if($breadcrumb['url']){
               		 			echo '<a href="' . $breadcrumb['url'] . '">' . $breadcrumb['name'] . 
               		 				'</a>';
               		 			}
               		 			else{
									echo $breadcrumb['name'];
								}
          		 	 		} 
          		 	 		?>
        				</div>
        				
                		<div class="post-title-l">
                			<span>
                			<?php echo $data->title; ?>
                			</span>
                		</div> 
                		
                		<div class="bar-share">
                			<div class="post-up">
                			    <span class="num"> <?php echo $data->ding;?></span>
                				<span class="up-act"> 顶 </span>
                			</div>
                			
                			<div class="bs-collect">
                				<a href="javascript:void(0);" rel="nofollow" onclick="show_login();" 
                					title="收藏" class="bs-btn"><i></i><span>收藏&nbsp;
                					<span class="num_fav_total"></span></span></a>
                			</div>
                			
                			<div class="bs-share">
                			</div>
                		</div> 
                </div>
             </div>
             
            <div class="post-wrap"> 
            	<div class="post-main">
            		<div class="post-item">
            			<div class="author-info">
            				<div class="avatar-box">
            				<?php 
            					$author=$data->author;
            					if($author->pic){
            						echo '<img src="'.Yii::app()->baseUrl. $author->pic.
            							'" height="50" width="50">';
            					} 
            					else
            					{
            						echo '<img src="'.Yii::app()->baseUrl. "/upload/user/default.png".
            						'" height="50" width="50">';
            					}
            				
            				?>
            				</div>
            				<div class="tools">
            					<div class="f1">
            						<span class="name">
            						<?php echo $author->username; ?>
            					 	</span> 
            					 	<span class="date">	
            					 	 <?php echo date('Y-m-d H:i:s',$data->create_time);?>
            					 	</span>
                    			</div>
                    			<div class="act3">
                    				<a href="">只看楼主</a>&nbsp;&nbsp;
                    				<a class="reply" href="<?php 
                    				$redirect_url = Yii::app()->request->url.'#ext-comment-form';
                    				if(Yii::app()->user->isGuest){
										echo Yii::app()->createUrl("/user/login", array(
											'redirect'=>$redirect_url));
									}
									else{
                    					echo $redirect_url;
                    				}				
                    				?>">回复</a>
                    				
                    				<?php if(Yii::app()->User->getId()==$data->author_id){
									?>
									<a class="edit" href="<?php 
										echo Yii::app()->createUrl("/post/update", array(
										'id'=>$data->id));
									?>">编辑</a>
									
									<?php
									echo CHtml::link("删除", '#', array('submit'=>array('post/delete', "id"=>$data->id), 
										'confirm' => '确认删除?'));
										
								} 
								?>
								</div>

                    		</div>
                		</div>
                
						<div>
                			<?php echo $data->content; ?>
           		 		</div>
           		 		
           		 	</div>
           		 </div>
           		 
            </div>
            
            <!--  
            <div class="post_nav">
                    <b>Tags:</b>
                    <?php echo implode(', ', $data->tagLinks); ?>
                    <br/>
                    <?php echo CHtml::link('Permalink', $data->getUrl()); ?> |
                    <?php echo CHtml::link("Comments ({$data->commentCount})",$data->url.'#comments'); ?> |
                    Last updated on <?php echo date('F j, Y',$data->update_time); ?>
                </div>
            </div>
            -->

            <!-- sidebar -->
        </div>
    </div>
</div>

<script>
//$('.reply').click(function(){
//		$(“html,body”).animate({scrollTop:$("#ext-comment-form").offset().top},1000)
//	});
</script>