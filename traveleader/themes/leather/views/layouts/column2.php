<?php $this->beginContent('/layouts/main'); ?>
    <div class="container" style="overflow: hidden">
        <div class="grid_18 alpha">
            <div id="content">
                <?php echo $content; ?>
            </div>
            <!-- content -->
        </div>

            <div class="box">
                <?php $this->widget('RecentComments', array(
                    'maxComments' => Yii::app()->params['recentCommentCount'],
                    'htmlOptions' => array('class' => 'box-title')
                )); ?>
            </div> 
            <!-- sidebar -->
        </div>
    </div>
<?php $this->endContent(); ?>