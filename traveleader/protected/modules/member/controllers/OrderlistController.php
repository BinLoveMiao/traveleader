<?php

class OrderlistController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/member';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('detail','admin','create','update', 'review', 'reviewsubmit'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular orderItem.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$order_item = OrderItem::model()->findByPk($id);
		$this->render('view',array(
			'Order'=>$order_item->order,
			'order_item' => $order_item,
		));
	}
	
	/**
	 * Show detail of an order. 
	 * An order can contains multiple orderItems
	 * @param unknown $id
	 */
    public function actionDetail($id)
    {
        //$order_item = OrderItem::model()->findByPk($id);
        //$order_items = $order->orderItems;
    	//$order_item = OrderItem::model()->findAllByPk($id);
    	//$order = $order_item->order;
    	$order = Order::model()->findByPk($id);
        $this->render('detail', array(
            'Order' => $order, 'order_items' => $order->orderItems
        ));
    }
    
    public function actionReview($id)
    {
    	//$order = Order::model()->findByPk($id);
    	$order_item = OrderItem::model()->findByPk($id);
    	//$order = $order_item->order;
    	if($order_item->status != strval(OrderItem::STATUS_TRAVELLED)){
    		throw new CHttpException(404, '未出游，不能评论');
    	}
    	//$order_items = $order->orderItems;
    	$this->render('create_review', array(
    			'order_id' => $order_item->order_id, 'order_item' => $order_item
    	));
    }
    
    public function actionReviewSubmit($id){
    	//$order = Order::model()->findByPk($id);
    	//$order_items = $order->orderItems;
		$order_item = OrderItem::model()->findByPk($id);

    	$review = new Review;
    	$review->customer_id = $_POST['anony'] ? '0': Yii::app()->user->id;
    	$review->entity_pk_value = $order_item->item_id;
    	$review->content = $_POST['overall-review-'.$order_item->item_id];
    	$review->rating = $_POST['rating-content-overall-'.$order_item->item_id];
    	$review->guide_review = $_POST['guide-review-'.$order_item->item_id];
    	$review->guide_rating = $_POST['rating-content-guide-'.$order_item->item_id];
    	$review->schedule_review = $_POST['schedule-review-'.$order_item->item_id];
    	$review->schedule_rating = $_POST['rating-content-schedule-'.$order_item->item_id];
    	$review->meal_review = $_POST['meal-review-'.$order_item->item_id];
    	$review->meal_rating = $_POST['rating-content-meal-'.$order_item->item_id];
    	$review->transport_review = $_POST['guide-review-'.$order_item->item_id];
    	$review->transport_rating = $_POST['rating-content-transport-'.$order_item->item_id];
    	$review->entity_id = "1";
    	$review->create_at = time();
    	$review->photos_exit = "0";
    		
    	if($review->save()){
    		$item = Item::model()->findByPk($order_item->item_id);
    		$item->review_count += 1; //Add the review count
    		$item->save();			
    		if($order_item->is_review == "0"){
    			$order_item->is_review = "1";
    			$order_item->save();
    		}
    	}
    	else{
    		throw new CHttpException(404, 'Review failed.');
    	}
    	//if($order->review_status == "0"){
    	//	$order->review_status = "1";
    	//	$order->save();
    	//}
    	// Should reconsider the redirecting page after review
    	$model=new Order('search');
    	$model->unsetAttributes();  // clear any default values
    	if(isset($_GET['Order']))
    		$model->attributes=$_GET['Order'];
    	 
    	$this->render('admin',array(
    			'model'=>$model,
    	));

    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Order;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Order']))
		{
			$model->attributes=$_POST['Order'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->order_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Order']))
		{
			$model->attributes=$_POST['Order'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->order_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Order');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Order('search');
		//$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Order']))
			$model->attributes=$_GET['Order'];
		/*
		$dataProvider = new CActiveDataProvider('Order',array(
			'criteria'=>array(
				'join' => 'LEFT JOIN order_item oi
					ON oi.order_id = t.order_id',	
				//'with' => array('orderItems'=>array('joinType'=>'LEFT JOIN')),
				'condition' => 't.user_id='.Yii::app()->user->getId(),
				'order' => 't.create_time DESC',
				'select' => array('t.order_id', 't.create_time', 't.total_fee, t.status',
					'`oi`.`order_item_id` as `order_item_id`', 
					'`oi`.`item_id` as `item_id`', 
					'`oi`.`title` as `title`', 
					'`oi`.`status` as `status2`',
					'`oi`.`is_review` as `is_review`'
				)
			),
		));*/
		
		//print_r($dataprovider->getData()); exit;	
		$this->render('admin',array(
			'data'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Order::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
