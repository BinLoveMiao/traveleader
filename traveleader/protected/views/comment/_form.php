<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>true,
)); ?>

<!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->

<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'author'); ?>
<!--		--><?php //echo $form->textField($model,'author',array('size'=>60,'maxlength'=>128,'value'=>Yii::app()->user->name)); ?>
<!--		--><?php //echo $form->error($model,'author'); ?>
<!--	</div>-->
<!---->
<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'email'); ?>
<!--		--><?php //echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128,'value'=>Yii::app()->user->email)); ?>
<!--		--><?php //echo $form->error($model,'email'); ?>
<!--	</div>-->
<!---->
<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'url'); ?>
<!--		--><?php //echo $form->textField($model,'url',array('size'=>60,'maxlength'=>128)); ?>
<!--		--><?php //echo $form->error($model,'url'); ?>
<!--	</div>-->
<!---->
<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'content'); ?>
<!--		--><?php //echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
<!--		--><?php //echo $form->error($model,'content'); ?>
<!--	</div>-->

<!--	<div class="row buttons">-->
<!--		--><?php //echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save'); ?>
<!--	</div>-->

    <div style="border-top:3px solid darkgray;height:800px; background:#ffffff;padding:0 20px;"> <!--留言板-->
        <div class="col-xs-8" style="margin-top: 20px;">
            <p style="color: red;font-size: 16px;">用户名（*）：<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>128,'value'=>Yii::app()->user->name)); ?><?php echo $form->error($model,'author'); ?></p>
            <p style="color: red;font-size: 16px;">邮箱（*）：<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?><?php echo $form->error($model,'email'); ?></p>
<!--            <p style="color: red;font-size: 16px;">--><?php //echo Yii::app()->user->name; ?><!--</p>-->
            <textarea class="form-control" style="height: 100px;" id="a123"<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?><?php echo $form->error($model,'content'); ?></textarea>
        </div>
        <div class="col-xs-4" style="height:100px;padding: 135px 50px 5px 30px; ">
            <button class="btn btn-danger " id="submit-comment" style="width:100px;height:30px; font-size:16px;padding:2px 20px;font-family:'楷体' "><?php echo ($model->isNewRecord ? '发表评论' : 'Save'); ?></button>
        </div>
        <script type="text/javascript">

            window.onload=function(){

                var oBtn=document.getElementById('submit-comment');
                var oUl=document.getElementById('comments-list');
                var oLi=document.getElementById('copy');
                var oTxt=document.getElementById('a123');

                oBtn.onclick=function(){

                    var gLi=document.createElement('li');
                    var oPtxt=document.getElementById('author-comment');
                    var ptxt=gLi.getElementsByTagName('p');
                    oPtxt.innerHTML=oTxt.value;
                    gLi.innerHTML=oLi.innerHTML;
                    oUl.insertBefore(gLi,null);

                };
            }
        </script>
        <hr/>
        <div class="col-xs-12" style="margin-top:50px; border-top: 2px dotted darkgray;"><!--评论列表-->
<!--            <ul id="comments-list" >-->
<!--                <li class="clearfix" id="copy">-->
<!--                    <div style="border-bottom: 1px solid gray; height: 100px;">-->
<!--                        <div class="col-xs-2 pull-left" style="text-align:center;vertical-align: middle;">-->
<!--                            <img src="http://avatar.csdn.net/B/3/2/3_wuyuanjingni.jpg">-->
<!--                        </div>-->
<!--                        <div class="col-xs-10 pull-right">-->
<!--                            <h4 style="color: red" id="author">demo:</h4>-->
<!--                            <p id="author-comment">-->
<!--                                这篇文献不错 ，讲得很有理！！赞一个！-->
<!--                            </p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </li>-->
<!---->
<!---->
<!--            </ul>-->
<!--            <ul class="pagination pull-right" id="news-pag-two">-->
<!--                <li><a href="#">&laquo;</a></li>-->
<!--                <li><a href="#">1</a></li>-->
<!--                <li><a href="#">2</a></li>-->
<!--                <li><a href="#">3</a></li>-->
<!---->
<!--                <li><a href="#">&raquo;</a></li>-->
<!--            </ul>-->
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->