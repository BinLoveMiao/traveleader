<div class="form">

<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap.min.js');
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/ajaxupload.js');
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/css/post.css');
$cs->registerCssFile(Yii::app()->baseUrl . '/ueditor1_2_5/themes/iframe.css');
$form=$this->beginWidget('CActiveForm'); ?>

	<!-- <p class="note">标记为 <span class="required">*</span> 的项目必须填写.</p> -->

	<?php echo CHtml::errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'标题'); ?>
		<?php echo $form->textField($model,'title',array('size'=>100,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'封面图片'); ?>
		<?php echo CHtml::hiddenField('image_id', $image->id);?>
		<?php 
		$this->widget('ext.imageAttachment.ImageAttachmentWidget', array(
				'model' => $image,
				'behaviorName' => 'coverBehavior',
				'apiRoute' => 'post/saveImageAttachment',
		));
		?>
		<?php echo $form->error($model,'cover_pic'); ?>
	</div>
	
	<div class="row" data-url="<?php echo Yii::app()->createUrl('post/getChildAreas'); ?>">
		 <?php echo $form->label($model,'景点'); ?>
         <?php
               $state_data = Area::model()->findAll("grade=:grade",
               		array(":grade" => 1));
               $state = CHtml::listData($state_data, "area_id", "name");
               $s_default = $default_state ? $default_state : ''; 
               //$empty_str = $default_state ? '请选择省份' : $default_state->name;
               echo '&nbsp;' . CHtml::dropDownList('AddressResult[state]', $s_default, $state,
               array(
                   'empty' => "请选择省份",
                   'ajax' => array(
                   'type' => 'GET', //request type
                   'url' => Yii::app()->createUrl('post/dynamiccities'), //url to call
                   'update' => '#AddressResult_city', //selector to update
                   'data' => 'js:"AddressResult_state="+jQuery(this).val()',
               )));
               //empty since it will be filled by the other dropdown
               $c_default = $default_city ? $default_city : '';
               if ($default_state) {
               		//$city_data = Area::model()->findAll("parent_id=:parent_id",
                    //  array(":parent_id" => $default_state->area_id));
                    $city_data = $default_state->childArea;
                    $city = CHtml::listData($city_data, "area_id", "name");
               }
               $city_update = $default_state ? $city : array();
              echo '&nbsp;&nbsp;' . CHtml::dropDownList('AddressResult[city]', $c_default, $city_update,
              array(
                    'empty' => '请选择城市',
                    'ajax' => array(
                    'type' => 'GET', //request type
                    'url' => Yii::app()->createUrl('post/dynamicsceneries'), //url to call
                    'update' => '#AddressResult_district', //selector to update
                    'data' => 'js:"AddressResult_city="+jQuery(this).val()',
              )));
              
              $s_default = $default_scenery ? $default_scenery: '';
              if ($default_city) {
                     //$district_data = Area::model()->findAll("city=:area_id",
                    //       array(":area_id" => $default_city->area_id));
                    $district_data= $default_city->citySceneries;
                     $district = CHtml::listData($district_data, "id", "name");
              }
              $district_update = $default_city ? $district : array() ;
              echo '&nbsp;&nbsp;' . CHtml::dropDownList('AddressResult[district]', $s_default, $district_update,
              array(
                     'empty' => '请选择景区',
              ));
         ?>
         <?php echo $form->error($model,'scenery'); ?>
    </div>
	
	<!--  
	<div class="row">
		<?php //echo $form->labelEx($model,'content'); ?>
		<?php //echo CHtml::activeTextArea($model,'content',array('rows'=>10, 'cols'=>70)); ?>
		<p class="hint">You may use <a target="_blank" href="http://daringfireball.net/projects/markdown/syntax">Markdown syntax</a>.</p>
		<?php //echo $form->error($model,'content'); ?>
	</div>
	-->
	<!--  
	<div class="row">
		<?php //echo $form->labelEx($model,'标签'); ?>
		<?php //$this->widget('CAutoComplete', array(
			//'model'=>$model,
			//'attribute'=>'tags',
			//'url'=>array('suggestTags'),
			//'multiple'=>true,
			//'htmlOptions'=>array('size'=>50),
		//)); ?>
		<p class="hint">请用逗号分隔不同标签</p>
		<?php //echo $form->error($model,'tags'); ?>
	</div>
	-->

	<div class="row">
		<?php echo $form->labelEx($model,'状态'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('PostStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'摘要'); ?>
		<?php echo $form->textArea($model,'summary',array('maxlength'=>1024, 
		'style'=>'height:120px;width:650px;padding: 5px 5px 90px;resize:none')); ?>
		<?php echo $form->error($model,'summary'); ?>
	</div>
	
	<div class="row ueditor">
		<?php echo $form->labelEx($model,'我游我记'); ?>
		<?php 
	// The toolbars can be seen in http://ueditor.baidu.com/doc/
		$this->widget('ext.wdueditor.WDueditor',array(
        'model' => $model,
        'attribute' => 'content',
		'width' =>'86%',
        'height' =>'1000',
        'toolbars' =>array(
            'FullScreen','Undo', 'Redo','Bold', 'italic',
			'cleardoc', 'forecolor', 'backcolor', 'fontsize', 'fontfamily',
			'fontborder', 'removeformat', 'formatmatch', 'horizontal', 'imagefloat',
			 'insertparagraph', 'justify',
			'lineheight', 'link', 'unlink', 'pagebreak',
			'paragraph', 'rowspacing', 'slectall', 'time', 'date',
			'imagefloat', 'insertimage', 'insertvideo', 'music',
			'preview', 'print',
        ),
	));
	?>
	<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '发布' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
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