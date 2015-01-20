<?php

class Post extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tbl_post':
	 * @var integer $id
	 * @var integer $category_id // Reserve for future use
	 * @var string $title
	 * @var string $summary
	 * @var string $content
	 * @var string $author_id
	 * @var string $tags
	 * @var integer $status
	 * @var integer $views
	 * @var integer $ding
	 * @var string $cover_pic
	 * @var string language
	 * @var string $create_time
	 * @var string $update_time

	 * @var integer $is_best
	 * @var string $country
	 * @var string $state
	 * @var string $city
	 * @var string $scenery_id
	 */
	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_ARCHIVED=3;

	private $_oldTags;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{post}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content, status', 'required'),
			array('status', 'in', 'range'=>array(1,2,3)),
			//array('is_best', 'in', 'range'=>array(0,1)),
			array('title', 'length', 'max'=>128),
			array('cover_pic', 'length', 'max'=>512),
			array('language', 'length', 'max'=>45),
			//array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'),
			//array('tags', 'normalizeTags'),
			array('views, ding, item_id, scenery_id, country, state, city', 'numerical', 'integerOnly' => true),
			array('views, ding, scenery_id, country, state, city, image_id', 'length', 'max' => 10),
			array('title, status, views, ding, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			//'comments' => array(self::HAS_MANY, 'Comment', 'owner_id', 'condition'=>'t.status='.Comment::STATUS_APPROVED, 'order'=>'t.create_time DESC'),
			//'commentCount' => array(self::STAT, 'Comment', 'owner_id', 'condition'=>'t.status='.Comment::STATUS_APPROVED),
			'item' => array(self::BELONGS_TO, 'Item', 'item_id'),
			'area_country' => array(self::BELONGS_TO, 'Area', 'country'),
			'area_state' => array(self::BELONGS_TO, 'Area', 'state'),
			'area_city' => array(self::BELONGS_TO, 'Area', 'city'),
			'scenery' => array(self::BELONGS_TO, 'Scenery', 'scenery_id'),
			'sceneryImgs' => array(self::HAS_MANY, 'SceneryImg', 'post_id')
		);
	}
	
	public function behaviors() {
		return array(
			'commentable' => array(
					'class' => 'ext.comment-module.behaviors.CommentableBehavior',
					// name of the table created in last step
					'mapTable' => 'posts_comments_nm',
						// name of column to related model id in mapTable
					'mapRelatedColumn' => 'postId'
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('post', 'id'),
			'category_id' => Yii::t('post', 'category_id'),
			'title' => Yii::t('post', 'title'),
			'summary' => Yii::t('post', 'summary'),
			'content' => Yii::t('post', 'content'),
			'tags' => Yii::t('post', 'tags'),
			'status' => Yii::t('post', 'status'),
			'views' => Yii::t('post', 'views'),
			'ding' => Yii::t('post', 'ding'),
			'create_time' => Yii::t('post', 'create_time'),
			'update_time' => Yii::t('post', 'update_time'),
			'author_id' => Yii::t('post', 'author_id'),
			'language' => Yii::t('post', 'language'),
			'cover_pic' => Yii::t('post', 'cover_pic'),
			'is_best' => Yii::t('post', 'is_best'),
			'item_id' => Yii::t('post', 'item_id'),
			'country' => Yii::t('post', 'country'),
			'state' => Yii::t('post', 'state'),
			'city' => Yii::t('post', 'city'),
			'scenery_id' => Yii::t('post', 'scenery_id'),
		);
	}

	/**
	 * @return string the URL that shows the detail of the post
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl('post/view', array(
			'id'=>$this->id,
		));
	}

	/**
	 * @return array a list of links that point to the post list filtered by every tag of this post
	 */
	public function getTagLinks()
	{
		$links=array();
		foreach(Tag::string2array($this->tags) as $tag)
			$links[]=CHtml::link(CHtml::encode($tag), array('post/index', 'tag'=>$tag));
		return $links;
	}

	/**
	 * Normalizes the user-entered tags.
	 */
	public function normalizeTags($attribute,$params)
	{
		$this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
	}

	/**
	 * Adds a new comment to this post.
	 * This method will set status and post_id of the comment accordingly.
	 * @param Comment the comment to be added
	 * @return boolean whether the comment is saved successfully
	 */
	public function addComment($comment)
	{
		if(Yii::app()->params['commentNeedApproval'])
			$comment->status=Comment::STATUS_PENDING;
		else
			$comment->status=Comment::STATUS_APPROVED;
		$comment->post_id=$this->id;
		return $comment->save();
	}
	
	/**
	 * @author Mr. Box
	 * @copyright 2014
	 *
	 * 百度富文本编辑器编辑出的内容转成数组。根据<p>元素
	 * 分文本、图片两种
	 */
	/**
	 * getImgs()
	 *
	 * @param integer $imgMaxWidth 限制显示图片的最大宽度。如果为0则输出原始大小。不为0等比缩放
	 * @param string $imgBasePath 图片路径：源代码中类似 '/uploads/images/xxxx.jpg'，输出：$imgBasePath.'/uploads/images/xxxx.jpg'
	 * @return Array
	 */
	public function getImgs($imgMaxWidth = 0, $imgBasePath = ''){
		$content = preg_replace("/<p>\s*<br\s*\/>\s*<\/p>/U", '<p>--break--</p>', $this->content); //如果要忽略手动换行，把此行代码注释掉
		$content = preg_replace("/<\/p>\s*<p[^>]*>/", '$$$###$$$', $content);
		$content = preg_replace("/<p[^>]*>|<\/p>/", '', $content);
		$matchs = explode('$$$###$$$', $content);
		$data = array();
		foreach($matchs as $key => $va){
			$va = preg_replace("/&nbsp;|　/i", '', strip_tags($va,'<img>,<br>'));
			$va = trim($va);
			$va = preg_replace("/<br[^>]*>/", '<br>',$va);
			if(strlen($va)){
				$imgArr = array();
				$imgPath = '';
				$imgName = '';
				$word = '';
				$hasimg = strpos($va,'<img');
				if($hasimg !== false){
					preg_match("/<img.+src\s*=\s*\"([^\"]+)\"[^>]*>/i",$va,$imgArr);
					if(isset($imgArr[1])){
						$imgPath = $imgBasePath.$imgArr[1];
						$imgLastA = strrpos($imgArr[1],"/");
						$imgLastD = strrpos($imgArr[1],".");
						$l = $imgLastD - strlen($imgArr[1]);
						$imgName = substr($imgArr[1],$imgLastA+1, $l);
						//下面两种方式，第二种根据本地路径，效率较快，第一种如果$imgBasePath为http远程路径，效率较慢
						#$imgsize = @getimagesize($imgPath);
						$imgsize = @getimagesize(getcwd().$imgArr[1]);
						if($imgsize === false){
							$imgHeight = 0;
							$imgWidth = 0;
						}else{
							$picW = $imgsize[0];
							$picH = $imgsize[1];
							if($imgMaxWidth == 0){
								//按实际高度输出
								$imgHeight = $picH;
								$imgWidth = $picW;
							}else{
								//根据宽度，等比输出高度
								if($imgMaxWidth < $picW){
									$imgHeight = round($imgsize[1]*$imgMaxWidth/$imgsize[0]);
									$imgWidth = $imgMaxWidth;
								}else{
									$imgWidth = $picW;
									$imgHeight = $picH;
								}
							}
						}
						$tmpArr = explode($imgArr[0], $va);
						if(count($tmpArr) > 1){
							if(preg_match('/\.(jpg|jpeg|png)(?:[\?\#].*)?$/i', $imgPath, $matches)){
								$data[] = $imgPath;
							}
						}else{
							//正常不会执行到此
						}
					}else{
						//正常不会执行到此
					}
				}
			}
		}
		return $data;
	}

	/**
	 * This is invoked when a record is populated with data from a find() call.
	 */
	protected function afterFind()
	{
		parent::afterFind();
		$this->_oldTags=$this->tags;
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->language = Yii::app()->language;
				$this->views = 0;
				$this->ding = 0;
				$this->is_best = 0;
				$this->create_time=$this->update_time=time();
				$this->author_id=Yii::app()->user->id;
			}
			else
				$this->update_time=time();
			return true;
		}
		else
			return false;
	}

	/**
	 * This is invoked after the record is saved.
	 */
	protected function afterSave()
	{
		parent::afterSave();
		Tag::model()->updateFrequency($this->_oldTags, $this->tags);
	}

	/**
	 * This is invoked after the record is deleted.
	 */
	protected function afterDelete()
	{
		parent::afterDelete();
		//Comment::model()->deleteAll('post_id='.$this->id);
		Tag::model()->updateFrequency($this->tags, '');
	}

	/**
	 * Retrieves the list of posts based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the needed posts.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('title',$this->title,true);
		//$criteria->compare('author_id', $this->author_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('author_id', Yii::app()->user->getId());
		//$criteria->compare('ding', $this->ding);
		//$criteria->compare('views', $this->views);
		//$criteria->compare('create_time', $this->create_time);
		
		return new CActiveDataProvider('Post', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'status, update_time DESC',
			),
		));
	}
	
	public function getStatusOptions()
	{
		return array(
				self::STATUS_DRAFT      => Yii::t('post','Draft'),
				self::STATUS_PUBLISHED  => Yii::t('post','Publish'),
				self::STATUS_ARCHIVED   => Yii::t('post','Archieve'),
		);
	}
}