<?php

class CartController extends YController
{
	
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
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'users' => array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}

    public function actionIndex()
    {
    	$cart = Yii::app()->cart;
    	$items = $cart->getPositions();
    	//print_r($items); exit;
    	//$item_prices[] = array();
    	//if(!empty($items)){
    	//	foreach($items as $item){
    	//		$item_prices[$item->item_id] = $item->itemPrices;
    	//	}
    	//}
        $this->render('index', array(
        	'cart' => $cart,
        	'items' => $items,
        	//'item_prices' => $item_prices
        )
        );
    }

    public function actionAdd()
    {
        $item = $this->loadItem();
        //$quantity = empty($_POST['qty']) ? 1 : intval($_POST['qty']);
        $adult_num = empty($_POST['qty']) ? 1 : intval($_POST['qty']);
        $child_num = empty($_POST['qty2']) ? 0 : intval($_POST['qty2']);
        $adult_price = $item->price;
        $child_price = $item->price;
    	$item_price_id = 0;
        $travel_date = "";
        if(!empty($_POST['item_price'])){
            $item_price_item = $_POST['item_price'];
            $item_price_id = intval(explode("|", $item_price_item)[0]);
            $travel_date = explode("|", $item_price_item)[1];
        }
        if($item_price_id != 0){
        	$item_price = ItemPrice::model()->findByPk($item_price_id);
        	$adult_price = $item_price->price_adult;
        	$child_price = $item_price->price_child;
        }
        if(Yii::app()->cart->put($item, $adult_num, $child_num, $adult_price, $child_price, $travel_date))
            echo json_encode(array('status' => 'success','number' => count(Yii::app()->cart)));
        else
            echo json_encode(array('status' => 'success'));
    }

    /*
    public function actionUpdate()
    {
       $sku=Sku::model()->findByPk(substr($_POST['sku_id'],3));
        if($sku->stock<$_POST['qty']){
            echo  '<div id="error-message" style="color:red">库存数量不足。</div>';
        }else{
            $item = CartItem::model()->with('skus')->findByPk(intval($_POST['item_id']));
            $item->cartProps = empty($_POST['props']) ? '' : $_POST['props'];
        $quantity = empty($_POST['qty']) ? 1 : intval($_POST['qty']);
        Yii::app()->cart->update($item, $quantity);
        }
    }*/
    public function actionUpdate(){
    	//$item = CartItem::model()->findByPk(intval($_POST['item_id']));
    	$item = CartItem::model()->findByPk(intval($_POST['item_id']));
    	//print_r($item); exit;
    	$adult_num = empty($_POST['adult_num']) ? 1 : intval($_POST['adult_num']);
    	//$adult_num = empty($_GET['adult_num']) ? $item->getAdultNumber() : intval($_GET['adult_num']);
    	$child_num = empty($_POST['child_num']) ? 0 : intval($_POST['child_num']);
    	$adult_price = empty($_POST['adult_price'])? $item->price : intval($_POST['adult_price']);
    	$child_price = empty($_POST['child_price'])? $item->price : intval($_POST['child_price']);
    	$travel_date = empty($_POST['date'])? date('Y-m-d') : $_POST['date'];
    	//$child_price = $item->getChildPrice(); 
    	//$travel_date = $item->getDate();
    	
    	Yii::app()->cart->update($item, $adult_num, $child_num, $adult_price, $child_price,
        	$travel_date);
    }

    public function actionRemove($key)
    {
        Yii::app()->cart->remove($key);
        $this->redirect('index');
    }

    public function actionClear()
    {
        Yii::app()->cart->clear();
        $this->redirect('index');
    }

    public function loadItem()
    {
        if (empty($_POST['item_id'])) {
            throw new CHttpException(400, 'Bad Request!.');
        }
        //$item = CartItem::model()->with('skus')->findByPk(intval($_POST['item_id']));
        $item = CartItem::model()->findByPk(intval($_POST['item_id']));
        //print_r($item); exit;
        if (empty($item)) {
            throw new CHttpException(400, 'Bad Request!.');
        }
        //$item->cartProps = empty($_POST['props']) ? '' : $_POST['props'];
        return $item;
    }

    public function actionGetPrice()
    {
        $positions = isset($_POST['positions']) ? $_POST['positions'] : array();
        $cart = Yii::app()->cart;
        $totalPrice = 0;
        foreach ($positions as $key) {
            $item = $cart->itemAt($key);
            $totalPrice += $item->getSumPrice();
        }
        echo json_encode(array('total' => $totalPrice));
    }
}