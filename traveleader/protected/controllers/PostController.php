<?php

class PostController extends Controller
{
	public $layout='column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated users to access all actions
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$post=$this->loadModel();
		$this->breadcrumbs[] = array(
				'name' => '我游我记>> ', 'url' => Yii::app()->createUrl('/post/index'),
		);
		
		$country = Area::model()->findByPk($post->country);
		$state = Area::model()->findByPk($post->state);
		$city = Area::model()->findByPk($post->city);
		
		$this->breadcrumbs[] = array('name' => $country->name. "旅游" .'>> ',
				'url' => Yii::app()->createUrl('/post/index', array('country' => $country->area_id)));
		$this->breadcrumbs[] = array('name' => $state->name. "旅游" .'>> ',
				'url' => Yii::app()->createUrl('/post/index', array('state' => $state->area_id)));
		$this->breadcrumbs[] = array('name' => $city->name. "旅游" .'>> ',
				'url' => Yii::app()->createUrl('/post/index', array('city' => $city->area_id)));
		
		
		$comment=$this->newComment($post);

		$this->render('view',array(
			'model'=>$post,
			'comment'=>$comment,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Post;
		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{	
		$criteria=new CDbCriteria(array(
				'condition'=>'status='.Post::STATUS_PUBLISHED,
				//'order'=>'update_time DESC',
				'with'=>'commentCount',
		));
		$this->breadcrumbs[] = array(
				'name' => '我游我记>> ', 'url' => Yii::app()->createUrl('/post/index'),
		);
		if(!empty($_GET['country'])){
			$criteria->addCondition("t.country = '{$_GET['country']}'");
			$country = Area::model()->findByPk($_GET['country']);
			$sceneries = $country->countrySceneries;
		}
		if(!empty($_GET['state'])){
			$criteria->addCondition("t.state = '{$_GET['state']}'");
			$state = Area::model()->findByPk($_GET['state']);
			$country = Area::model()->findByPk($state->parent_id);
			$sceneries = $state->stateSceneries;
		}
		if(!empty($_GET['city'])){
			$criteria->addCondition("t.city = '{$_GET['city']}'");
			$city = Area::model()->findByPk($_GET['city']);
			$state = Area::model()->findByPk($city->parent_id);
			$country = Area::model()->findByPk($state->parent_id);
			$sceneries = $city->citySceneries;
		}
		if(!empty($_GET['scenery'])){
			$criteria->addCondition("t.scenery_id = '{$_GET['scenery']}'");
			$scenery = Scenery::model()->findByPk($_GET['scenery']);
			$country = Area::model()->findByPk($scenery->country);
			$state = Area::model()->findByPk($scenery->state);
			$city = Area::model()->findByPk($scenery->city);
			$sceneries = $scenery->getAllChildren(8);
		}
		
		if($country){
			if($country->name != '中国'){
				$this->breadcrumbs[] = array('name' => $country->name. "旅游" .'>> ',
						'url' => Yii::app()->createUrl('/post/index', array('country' => $country->area_id)));
			}
			$scenery2 = $country;
		}
		if($state){
			$this->breadcrumbs[] = array('name' => $state->name. "旅游" .'>> ',
					'url' => Yii::app()->createUrl('/post/index', array('state' => $state->area_id)));
			$scenery2 = $state;
		}
		
		if($city){
			$this->breadcrumbs[] = array('name' => $city->name. "旅游" .'>> ',
					'url' => Yii::app()->createUrl('/post/index', array('city' => $city->area_id)));
			$scenery2 = $city;
		}
		if($scenery){
			$this->breadcrumbs[] = array('name' => $scenery->name .'>> ',
					'url' => Yii::app()->createUrl('/post/index', array('scenery' => $scenery->id)));
			$scenery2 = $scenery;
		}
		
		if(empty($_GET['scenery']) && !$sceneries){
			$sceneries = Scenery::getSceneries(8);
		}
		
		if (!empty($_GET['sort'])) {
			switch ($_GET['sort']) {
				case 'new':
					$criteria->order = 't.update_time DESC';
					break;
				case 'hot':
					$criteria->order = 't.views DESC';
					break;
				case 'best':
					$criteria->addCondition("t.is_best = 1");
					$criteria->order = 't.update_time DESC';
					break;	 	
				default: 
					$criteria->order = 't.update_time DESC';
					break;
			}
		}
		
		if(isset($_GET['tag']))
			$criteria->addSearchCondition('tags',$_GET['tag']);
		
		
        $posts = Post::model()->findAll($criteria);

		$dataProvider=new CActiveDataProvider('Post', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['postsPerPage'],
			),
			'criteria'=>$criteria,
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
            'posts' => $posts,
			'scenery' => $scenery2,
			'sceneries' => $sceneries,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Suggests tags based on the current user input.
	 * This is called via AJAX when the user is entering the tags input.
	 */
	public function actionSuggestTags()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$tags=Tag::model()->suggestTags($keyword);
			if($tags!==array())
				echo implode("\n",$tags);
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
			{
				if(Yii::app()->user->isGuest)
					$condition='status='.Post::STATUS_PUBLISHED.' OR status='.Post::STATUS_ARCHIVED;
				else
					$condition='';
				$this->_model=Post::model()->findByPk($_GET['id'], $condition);
			}
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Creates a new comment.
	 * This method attempts to create a new comment based on the user input.
	 * If the comment is successfully created, the browser will be redirected
	 * to show the created comment.
	 * @param Post the post that the new comment belongs to
	 * @return Comment the comment instance
	 */
	protected function newComment($post)
	{
		$comment=new Comment;
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($comment);
			Yii::app()->end();
		}
		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];
			if($post->addComment($comment))
			{
				if($comment->status==Comment::STATUS_PENDING)
					Yii::app()->user->setFlash('commentSubmitted','Thank you for your comment. Your comment will be posted once it is approved.');
				$this->refresh();
			}
		}
		return $comment;
	}
}
