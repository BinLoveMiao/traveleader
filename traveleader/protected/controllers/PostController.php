<?php

define(BRIEF_LENGTH,800);

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
			array('allow',  // allow all users to access 'index', 'view', 'create' actions.
				'actions'=>array('index','view', 'gallary'),
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
	
	public function actionUpload()
	{
        Yii::import("ext.EAjaxUpload.qqFileUploader");
 
        $folder='upload/post/tmp/';// folder for uploaded files
        $allowedExtensions = array("jpg", "jpeg", "png");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 5 * 1024 * 1024;// maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
 
        $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
        $fileName=$result['filename'];//GETTING FILE NAME
 
        echo $return;// it's array
	}
	
	
	public function actionUploadAdditional(){
		header( 'Vary: Accept' );
		if( isset( $_SERVER['HTTP_ACCEPT'] ) && (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
			header( 'Content-type: application/json' );
		} else {
			header( 'Content-type: text/plain' );
		}
	
		if( isset( $_GET["_method"] ) ) {
			if( $_GET["_method"] == "delete" ) {
				$success = is_file( $_GET["file"] ) && $_GET["file"][0] !== '.' && unlink( $_GET["file"] );
				echo json_encode( $success );
			}
		} else {
			$this->init( );
			$model = new Image;//Here we instantiate our model
	
			//We get the uploaded instance
			$model->file = CUploadedFile::getInstance( $model, 'file' );
			if( $model->file !== null ) {
				$model->mime_type = $model->file->getType( );
				$model->size = $model->file->getSize( );
				$model->name = $model->file->getName( );
				//Initialize the ddditional Fields, note that we retrieve the
				//fields as if they were in a normal $_POST array
				$model->title = Yii::app()->request->getPost('title', '');
				$model->description  = Yii::app()->request->getPost('description', '');
	
				if( $model->validate( ) ) {
					$path = Yii::app() -> getBasePath() . "/../images/uploads";
					$publicPath = Yii::app()->getBaseUrl()."/images/uploads";
					if( !is_dir( $path ) ) {
						mkdir( $path, 0777, true );
						chmod ( $path , 0777 );
					}
					$model->file->saveAs( $path.$model->name );
					chmod( $path.$model->name, 0777 );
	
					//Now we return our json
					echo json_encode( array( array(
							"name" => $model->name,
							"type" => $model->mime_type,
							"size" => $model->size,
							//Add the title
							"title" => $model->title,
							//And the description
							"description" => $model->description,
							"url" => $publicPath.$model->name,
							"thumbnail_url" => $publicPath.$model->name,
							"delete_url" => $this->createUrl( "upload", array(
									"_method" => "delete",
									"file" => $path.$model->name
							) ),
							"delete_type" => "POST"
					) ) );
				} else {
					echo json_encode( array( array( "error" => $model->getErrors( 'file' ), ) ) );
					Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ), CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction" );
				}
			} else {
				throw new CHttpException( 500, "Could not upload file" );
			}
		}
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$post=$this->loadModel();
		//Update the views
		$post->views = $post->views + 1;
		$post->save();
		
		$this->breadcrumbs = array(
				 Yii::t('main', 'my post') => Yii::app()->createUrl('/post/index'),
		);
		
		//$country = Area::model()->findByPk($post->country);
		$state = Area::loadModel($post->state);
		$scenery = Scenery::loadModel($post->scenery_id);
		$parentScenery = $scenery->parentScenery;
		//$city = Area::model()->findByPk($post->city);
		if($state){
			//$this->breadcrumbs[] = array('name' => $state->name. "旅游" .'>> ',
			//	'url' => Yii::app()->createUrl('/post/index', array('state' => $state->area_id)));
			$this->breadcrumbs = array_merge($this->breadcrumbs, array(
					$state->name. Yii::t('main', 'travel') => 
					Yii::app()->createUrl('/post/index', array('state' => $state->area_id))));
		}
		
		if($scenery){
			if($parentScenery){
				//$this->breadcrumbs[] = array('name' => $parentScenery->name.'>> ',
				//	'url' => Yii::app()->createUrl('/post/index', array('scenery' => $parentScenery->id)));
				$this->breadcrumbs = array_merge($this->breadcrumbs, array(
						$parentScenery->name =>
						Yii::app()->createUrl('/post/index', array('scenery' => $parentScenery->id))));
				
			}
		
			//$this->breadcrumbs[] = array('name' => $scenery->name. "旅游攻略" .'>> ',
			//	'url' => Yii::app()->createUrl('/post/index', array('scenery' => $scenery->id)));
			$this->breadcrumbs = array_merge($this->breadcrumbs, array(
					$scenery->name =>
					Yii::app()->createUrl('/post/index', array('scenery' => $scenery->id))));
		}
		
		//$this->breadcrumbs[] = array('name' => $post->title);
		$this->breadcrumbs = array_merge($this->breadcrumbs, array(
				$post->title => $post->getUrl()));

		$this->render('view',array(
			'model'=>$post,
			'comment'=>$comment,
		));
	}
	
	public function actionGallary(){
		$is_scenery = false;
		if(!empty($_GET['country'])){
			$area_id = $_GET['country'];
			$country = Area::loadModel($_GET['country']);
		}
		if(!empty($_GET['state'])){
			$area_id = $_GET['state'];
			$state = Area::loadModel($_GET['state']);
			$country = Area::loadModel($state->parent_id);
		}
		if(!empty($_GET['city'])){
			$area_id = $_GET['city'];
			$city = Area::loadModel($_GET['city']);
			$state = Area::loadModel($city->parent_id);
			$country = Area::loadModel($state->parent_id);
		}
		
		if(!empty($_GET['scenery'])){
			$area_id = $_GET['scenery'];
			$is_scenery = true;
			$scenery = Scenery::loadModel($_GET['scenery']);
			$country = Area::loadModel($scenery->country);
			$state = Area::loadModel($scenery->state);
			$city = Area::loadModel($scenery->city);
		}
		
		// Setup the breadcrumb
		if($country){
			if($country->name != '中国'){
				$this->breadcrumbs = array($country->name. Yii::t('main', 'travel')
						 => Yii::app()->createUrl('/post/gallary', array('country' => $country->area_id)));
			}
		}
		if($state){
			//$this->breadcrumbs[] = array('name' => $state->name. "旅游" .'>> ',
			//		'url' => Yii::app()->createUrl('/post/gallary', array('state' => $state->area_id)));
			$this->breadcrumbs = array_merge($this->breadcrumbs, array( $state->name. Yii::t('main', 'travel')
				=> Yii::app()->createUrl('/post/gallary', array('state' => $state->area_id))));
		}
		
		if($city){
			//$this->breadcrumbs[] = array('name' => $city->name. "旅游" .'>> ',
			//		'url' => Yii::app()->createUrl('/post/gallary', array('city' => $city->area_id)));
			$this->breadcrumbs = array_merge($this->breadcrumbs, array( $city->name. Yii::t('main', 'travel')
					=> Yii::app()->createUrl('/post/gallary', array('city' => $city->area_id))));
		}
		if($scenery){
			//$this->breadcrumbs[] = array('name' => $scenery->name .'>> ',
			//		'url' => Yii::app()->createUrl('/post/gallary', array('scenery' => $scenery->id)));
			$this->breadcrumbs = array_merge($this->breadcrumbs, array( $scenery->name
					=> Yii::app()->createUrl('/post/gallary', array('scenery' => $scenery->id))));
		}
		
		$this->breadcrumbs = array_merge($this->breadcrumbs, (array(Yii::t('main', 'gallary'))));

		$gallary = Scenery::getAllSceneryPictures($area_id, $is_scenery, 0);
		
		$this->render('gallary', array("gallary" => $gallary));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Post;
		//$image=new ImageTemp;
		//$image->id=time();
		//$image->name="test";
		//$image->save();

		$default_scenery=null;
		$default_state=null;
		$default_city=null;
		if(!empty($_GET['state'])){
			 $default_state=Area::model()->findByPk($_GET['state']);
		}
		if(!empty($_GET['city'])){
			$default_city=Area::model()->findByPk($_GET['city']);
			$default_state=$default_city->parentArea;
		}
		if(!empty($_GET['scenery'])){
			$default_scenery=Scenery::model()->findByPk($_GET['scenery'],
				new CDbCriteria(array("select" => "t.id, t.name, t.state, t.city")));
			$default_state=$default_scenery->stateArea;
			$default_city=$default_scenery->cityArea;
		}
		if(!empty($_GET['item'])){
			$item = Item::model()->findByPk($_GET['item']);
			$default_scenery = $item->scenery;
			$default_state = $item->stateArea;
			$default_city = $item->cityArea;
		}
		
		if(isset($_POST['Post']))
		{			
			$model->status = $_POST['Post']['status'];
			$model->content = $_POST['Post']['content'];
			$model->title= $_POST['Post']['title'];
			//$address=$_POST['AddressResult'];
			$model->country=empty($_POST['Post']['country'])? 
				100000 : $_POST['Post']['country'];
			$model->state=$_POST['Post']['state'];
			$model->city=$_POST['Post']['city'];
			$model->scenery_id=$_POST['Post']['scenery_id'];
			
			
			//$model->attributes = $_Post['Post'];
			
			if(!empty($_GET['item'])){
				$model->item_id = $_GET['item'];
			}
			else{
				$model->item_id = 0;
			}
			$model->cover_pic = $_POST['cover_pic'];
			$model->summary = $this->Generate_Brief($model->content);
			$model->tags = ""; // Save for further use
			$model->category_id = 0; // Save for further use
			
			if($model->validate()){
				$model->save();
				$images = $model->getImgs();
				foreach($images as $img){
					$sce_img = new SceneryImg;
					$sce_img->pic = $img;
					$sce_img->like = 0;
					$sce_img->scenery_id = $model->scenery_id;
					$sce_img->post_id = $model->id;
					$sce_img->save(); 
				}
				$this->redirect(array('view','id'=>$model->id));
			}
			else{
				throw new Exception("Create Post Error!");
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'default_scenery'=>$default_scenery,
			'default_state'=>$default_state,
			'default_city'=>$default_city,
			//'image'=>$image,
			
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
			$model->status = $_POST['Post']['status'];
			$model->content = $_POST['Post']['content'];
			$model->title= $_POST['Post']['title'];
			$model->country=empty($_POST['Post']['country'])?
				100000 : $_POST['Post']['country'];
			$model->state=$_POST['Post']['state'];
			$model->city=$address['city'];
			$model->scenery_id=$address['district'];
			$model->summary=$this->Generate_Brief($model->content);
			$model->tags = ""; // Save for further use
			$model->category_id = 0; // Save for further use
			if(!empty($_POST['cover_pic'])){
				$model->cover_pic = $_POST['cover_pic'];
			}
			//$model->attributes = $_POST['Post'];
			
			$model->tags = ""; // Save for further use
			$model->category_id = 0; // Save for further use
			if(!empty($_POST['cover_pic'])){
				$model->cover_pic = $_POST['cover_pic'];
			}

			if($model->validate()){
				$model->save();
				$this->redirect(array('view','id'=>$model->id));
			}
			else{
				throw new Exception("Update Post Error!");
			}
		}
		
		$default_state=$model->area_state;
		$default_city=$model->area_city;
		$default_scenery=$model->scenery;

		$this->render('update',array(
			'model'=>$model,
			//'image'=>$image,
			'default_scenery'=>$default_scenery,
			'default_state'=>$default_state,
			'default_city'=>$default_city,
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
			//print_r($this->loadModel()->getCommentDataProvider());
			// Delete the comments first
			foreach($this->loadModel()->getCommentDataProvider()->data as $data){
				$data->delete();
			}
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
				//'with'=>'commentCount',
		));
		
		//$this->breadcrumbs[] = array(
		//		'name' => '我游我记>>', 'url' => Yii::app()->createUrl('/post/index'),
		//);
		$this->breadcrumbs = array(Yii::t('main', 'my post')=> Yii::app()->createUrl('/post/index'));
		$area_id = 0;
		$is_scenery = false;
		if(!empty($_GET['country'])){
			$area_id = $_GET['country'];
			$criteria->addCondition("t.country = '{$_GET['country']}'");
			$country = Area::loadModel($_GET['country']);
		}
		if(!empty($_GET['state'])){
			$area_id = $_GET['state'];
			$criteria->addCondition("t.state = '{$_GET['state']}'");
			$state = Area::loadModel($_GET['state']);
			$country = Area::loadModel($state->parent_id);
		}
		if(!empty($_GET['city'])){
			$area_id = $_GET['city'];
			$criteria->addCondition("t.city = '{$_GET['city']}'");
			$city = Area::loadModel($_GET['city']);
			$state = Area::loadModel($city->parent_id);
			$country = Area::loadModel($state->parent_id);
		}
		
		if(!empty($_GET['scenery'])){
			$area_id = $_GET['scenery'];
			$is_scenery = true;
			$criteria->addCondition("t.scenery_id = '{$_GET['scenery']}'");
			$scenery = Scenery::loadModel($_GET['scenery']);
			$country = Area::loadModel($scenery->country);
			$state = Area::loadModel($scenery->state);
			$city = Area::loadModel($scenery->city);
		}
		
		// Set the breadcrumb and scenery object
		if($country){
			if($country->name != '中国'){
				//$this->breadcrumbs[] = array('name' => $country->name. "旅游" .'>> ',
						//'url' => Yii::app()->createUrl('/post/index', array('country' => $country->area_id)));
				$this->breadcrumbs = array_merge($this->breadcrumbs, array($country->name. Yii::t('main', 'travel') 
						=> Yii::app()->createUrl('/post/index', array('country' => $country->area_id))));
			}
			$scenery2 = $country;
		}
		if($state){
			//$this->breadcrumbs[] = array('name' => $state->name. "旅游" .'>> ',
			//		'url' => Yii::app()->createUrl('/post/index', array('state' => $state->area_id)));
			$this->breadcrumbs = array_merge($this->breadcrumbs, array($state->name. Yii::t('main', 'travel')
					 => Yii::app()->createUrl('/post/index', array('state' => $state->area_id))));
			$scenery2 = $state;
		}
		
		if($city){
			//$this->breadcrumbs[] = array('name' => $city->name. "旅游" .'>> ',
			//		'url' => Yii::app()->createUrl('/post/index', array('city' => $city->area_id)));
			$this->breadcrumbs = array_merge($this->breadcrumbs, array($city->name. Yii::t('main', 'travel') 
					=> Yii::app()->createUrl('/post/index', array('city' => $city->area_id))));
			$scenery2 = $city;
		}
		if($scenery){
			//$this->breadcrumbs[] = array('name' => $scenery->name .'>> ',
			//		'url' => Yii::app()->createUrl('/post/index', array('scenery' => $scenery->id)));
			$this->breadcrumbs = array_merge($this->breadcrumbs, array($scenery->name => Yii::app()->createUrl
					('/post/index', array('scenery' => $scenery->id))));
			$scenery2 = $scenery;
		}
		
		// Set sceneries for the display of hot sceneries
		$num_hot_sceneries = 8;
		// Set num_travellings and num_pics and main_pic
		$num_travel = 0;
		$num_pics = 0;
		$main_pic = "";
		
		if($area_id != 0){
			if($is_scenery){
				$sceneries = $scenery->getChildren($num_hot_sceneries);
				$main_pic = $scenery->main_pic;
			}
			else{
				$sceneries = Scenery::getAreaSceneries($area_id, false, $num_hot_sceneries);
				$main_pic = $sceneries[0]->main_pic;
			}
			foreach(Scenery::getAreaSceneries($area_id, $is_scenery, 0) as $sce){
				$num_travel += $sce->num_travel;
				$num_pics += $sce->num_pics;
			}
		}
		else{
			$sceneries = Scenery::getHotSceneries($num_hot_sceneries);
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

		//if(isset($_GET['tag']))
		//	$criteria->addSearchCondition('tags',$_GET['tag']);
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
			'num_pics' => $num_pics,
			'num_travel' => $num_travel,
			'main_pic' => $main_pic,
			'is_scenery' => $is_scenery,
		));
	}

	/**
	 * Manages all models.
	 */
	/*
	public function actionAdmin()
	{
		//$model=new Post('search');
		//if(isset($_GET['Post']))
		//	$model->attributes=$_GET['Post'];
		//$posts = Post::model()->findAll(
		//		new CDbCriteria(array(
		//			'condition' => 't.author_id='.Yii::app()->user->getId(),
		//			'order' => 't.create_time DESC',
		//			'select' => 't.id, t.title, t.status, t.create_time'
		//		)));
		$dataprovider = new CActiveDataProvider('Post',array(
				'criteria'=>array(
						'condition' => 't.author_id='.Yii::app()->user->getId(),
						'order' => 't.create_time DESC',
						'select' => 't.id, t.title, t.status, t.ding, t.views, t.create_time'
				),
		));
		$this->render('admin',array(
			'data'=>$dataprovider,
		));
	}*/

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
	
	private function Generate_Brief($text){
		global $Briefing_Length;
		mb_regex_encoding("UTF-8");
		if(mb_strlen($text) <= BRIEF_LENGTH ) return $text;
		$Foremost = mb_substr($text, 0, BRIEF_LENGTH);
	
		$re = "<(\/?)(P|DIV|H1|H2|H3|H4|H5|H6|ADDRESS|PRE|TABLE|TR|TD|TH|INPUT|SELECT|TEXTAREA|OBJECT|A|UL|OL|LI|BASE|META|LINK|HR|BR|PARAM|IMG|AREA|INPUT|SPAN)[^>]*(>?)";
		$Single = "/BASE|META|LINK|HR|BR|PARAM|IMG|AREA|INPUT|BR/i";
		 
		$Stack = array(); $posStack = array();
		 
		mb_ereg_search_init($Foremost, $re, 'i');
		 
		while($pos = mb_ereg_search_pos()){
			$match = mb_ereg_search_getregs();
			/*        [Child-matching Formulation]:
			  
			$matche[1] : A "/" charactor indicating whether current "<...>" Friction is Closing Part
			$matche[2] : Element Name.
			$matche[3] : Right > of a "<...>" Friction
			*/
	
			if($match[1]==""){
				$Elem = $match[2];
				if(mb_eregi($Single, $Elem) && $match[3] !=""){
					continue;
				}
				array_push($Stack, mb_strtoupper($Elem));
				array_push($posStack, $pos[0]);
			}else{
				$StackTop = $Stack[count($Stack)-1];
				$End = mb_strtoupper($match[2]);
				if(strcasecmp($StackTop,$End)==0){
					array_pop($Stack);
					array_pop($posStack);
					if($match[3] ==""){
						$Foremost = $Foremost.">";
					}
				}
			}
		}
		 
		$cutpos = array_shift($posStack) - 1;
		$Foremost =  mb_substr($Foremost,0,$cutpos,"UTF-8");
		return $Foremost;
	}
	
	public function actionGetChildAreas($parent_id)
	{
		$parent_area = Area::model()->findByPk($parent_id);
		if($parent_area->grade == 2){ // Means it is a city level
			$sceneries=$parent_area->citySceneries;
			$areasData = CHtml::listData($sceneries, 'id', 'name');
		}
		else{
			$areas = Area::model()->findAllByAttributes(array('parent_id' => $parent_id));
			$areasData = CHtml::listData($areas, 'area_id', 'name');
		}
		
		echo json_encode(CMap::mergeArray(array('0' => ''), $areasData));
	}
	
	public function actionDynamiccities() {
		echo $_GET['AddressResult_state'];
		$data = Area::model()->findAll("parent_id=:parent_id", array(":parent_id" => $_GET['AddressResult_state']));
	
		$data = CHtml::listData($data, "area_id", "name");
		echo CHtml::tag("option", array("value" => ''), '', true);
		foreach ($data as $value => $name) {
			echo CHtml::tag("option", array("value" => $value), CHtml::encode($name), true);
		}
	}
	
	public function actionDynamicsceneries() {
		if ($_GET["AddressResult_city"]) {
			//$data = Area::model()->findAll("parent_id=:parent_id", array(":parent_id" => $_GET["AddressResult_city"]));
			$city = Area::model()->findByPk($_GET["AddressResult_city"]);
			$data = $city->citySceneries;
			$data = CHtml::listData($data, "id", "name");
			foreach ($data as $value => $name) {
				echo CHtml::tag("option", array("value" => $value), CHtml::encode($name), true);
			}
		}
	}
	
}
