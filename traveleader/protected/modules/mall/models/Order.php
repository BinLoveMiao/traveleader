<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property string $order_id
 * @property string $user_id
 * @property integer $status 
 * // OrderStatus: 
 * 0 - wait_for_submit
 * 1 - submitted
 * 2 - wait_for_pay
 * 3 - paid
 * 4 - wait_for_refund
 * 5 - refunded
 * 6 - success
 * 7 - closed
 * @property integer $review_status 
 * @property string $total_fee
 * @property string $pay_fee
 * @property string $pay_method

 * @property string $receiver_country
 * @property string $receiver_state
 * @property string $receiver_city
 * @property string $receiver_district
 * @property string $receiver_address
 * @property string $receiver_zip
 * 
 * @property string $receiver_name
 * @property string $receiver_mobile
 * @property string $receiver_email
 * @property string $receiver_phone
 * @property string $memo
 * @property string $pay_time
 * 
 * @property integer $is_childen  // All members are children
 * @property integer $has_old_man
 * @property integer $has_foreigner
 * @property integer $is_invoice

 * // Order is marked as reviewed if all items under it has been reviewed
 * 
 * @property integer $whole_num_days
 * @property string $feature_item_name
 * 
 * @property string $create_time
 * @property string $update_time
 */
class Order extends CActiveRecord
{
	
	const STATUS_WAIT_SUBMIT=0;
	const STATUS_SUBMITTED=1;
	const STATUS_WAIT_PAY=2;
	const STATUS_PAID=3;
	const STATUS_WAIT_REFUND=4;
	const STATUS_REFUNDED=5;
	const STATUS_SUCCESS=6;
	const STATUS_CLOSED=7;
	const STATUS_TRAVELLED=8;

    private $orderLog;
    public $order_detail;
    public $ORDERITEM_order_item_id;
    public $ORDERITEM_item_id;
    public $ORDERITEM_title;
    public $ORDERITEM_status;
    public $ORDERITEM_is_review;
     
    public $id;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Order the static model class
     */

    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(){
        return 'order';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status, receiver_name, receiver_mobile, receiver_email', 'required'),
            array('status, review_status, ORDERITEM_status, ORDERITEM_is_review', 'numerical', 'integerOnly' => true),
        	array('status, ORDERITEM_status', 'in', 'range'=>array(0,1,2,3,4,5,6,7,8)),
        	array('is_children, has_old_man, has_foreigner, is_invoice', 'numerical', 'integerOnly' => true),
            array('user_id, total_fee, pay_fee, payment_method_id, pay_time, create_time, update_time', 'length', 'max' => 10),
            array('receiver_name, receiver_country, receiver_state, receiver_city, receiver_district, receiver_zip, receiver_mobile, receiver_email, receiver_phone', 'length', 'max' => 45),
            array('receiver_address', 'length', 'max' => 255),
            array('memo, ORDERITEM_order_item_id, $ORDERITEM_item_id, ORDERITEM_status, ORDERITEM_is_review', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('order_id, user_id, status, review_status, total_fee, pay_fee, ORDERITEM_status, ORDERITEM_is_review', 'safe', 'on' => 'search'),);
    }

    /**
     * @return array relational rules.
     */
    public function relations(){
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'paymentMethod' => array(self::BELONGS_TO, 'PaymentMethod', 'payment_method_id'),
            'orderItems' => array(self::HAS_MANY, 'OrderItem', 'order_id'),
            'orderLogs' => array(self::HAS_MANY, 'OrderLog', 'order_id'),
            'payments' => array(self::HAS_MANY, 'Payment', 'order_id'),
            'refunds' => array(self::HAS_MANY, 'Refund', 'order_id'),
            'users' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(){
        return array(
            'order_id' => Yii::t('Order', '订单号'),
            'user_id' => Yii::t('Order', '会员'),
            'status' => Yii::t('Order', '订单状态'),
        	'review_status' => Yii::t('Order', '点评状态'),
            'total_fee' => Yii::t('Order', '需付款'),
            'pay_fee' => Yii::t('Order', '实付款'),
            'pay_method' => Yii::t('Order', '付款方式'),
            'receiver_name' => Yii::t('Order', '联系人'),
            'receiver_country' => Yii::t('Order', '国家'),
            'receiver_state' => Yii::t('Order', '省'),
            'receiver_city' => Yii::t('Order', '市'),
            'receiver_district' => Yii::t('Order', '区'),
            'receiver_address' => Yii::t('Order', '详细地址'),
            'receiver_zip' => Yii::t('Order', '邮编'),
            'receiver_mobile' => Yii::t('Order', '手机'),
        	'receiver_email' => Yii::t('Order', '电子邮件'),
            'receiver_phone' => Yii::t('Order', '电话'),   		
        	'is_children' => Yii::t('Order', '儿童'),
        	'has_old_man' => Yii::t('Order', '有老人'),
        	'has_foreigner' => Yii::t('Order', '有外国人'),
        	'is_invoice' => Yii::t('Order', '需要发票'),
            'memo' => Yii::t('Order', '备注'),
            'pay_time' => Yii::t('Order', '付款时间'),
            'create_time' => Yii::t('Order', '下单时间'),
            'update_time' => Yii::t('Order', '更新时间'),
            'payment_method_id' => Yii::t('Order', '付款方式'),
            'detail_address' => Yii::t('Order', '具体地址'),
        	'order_detail' => '订单号 | 下单时间 | 需付款',
        	'ORDERITEM_title' => Yii::t('Order', '订单项目名称'),
        	'ORDERITEM_is_review' => Yii::t('Order', '订单点评状态'),
        	'ORDERITEM_status' => Yii::t('Order', '订单项目状态'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search(){
    	// Warning: Please modify the following code to remove attributes that
    	// should not be searched.
    	
    	$criteria = new CDbCriteria;
    	
    	$criteria->join='LEFT JOIN order_item oi ON oi.order_id = t.order_id';
    	$criteria->select=array('t.order_id', 't.create_time', 't.total_fee', 't.status',
    			'`oi`.`order_item_id` as `ORDERITEM_order_item_id`',
    			'`oi`.`item_id` as `ORDERITEM_item_id`',
    			'`oi`.`title` as `ORDERITEM_title`',
    			'`oi`.`status` as `ORDERITEM_status`',
				'`oi`.`is_review` as `ORDERITEM_is_review`');  	        
        $criteria->order='t.status, t.create_time DESC';
    
    	$criteria->compare('t.order_id', $this->order_id, true);
    	$criteria->compare('t.user_id', Yii::app()->user->id);
    	//$criteria->compare('t.status', $this->status);
    	$criteria->compare('oi.title', $this->ORDERITEM_title, true);
    	$criteria->compare('oi.status', $this->ORDERITEM_status);
    	$criteria->compare('oi.is_review', $this->ORDERITEM_is_review);
    	
    	return new CActiveDataProvider($this, array(
    	            'criteria' => $criteria));
    }

    public function showDetailAddress($model){
        $data['receiver_country'] = $model->receiver_country;
        foreach (array( 'state', 'city', 'district') as $value) {
            $data['receiver_' . $value] = Area::model()->findByPk($model->{'receiver_' . $value})->name;
        }
        $data['receiver_address'] = $model->receiver_address;
        $detail_address = implode(' ', $data);
        return $detail_address;

    }
    
    public function getOrderDetail(){
    	$detail = $this->getAttributeLabel('order_id'). ': ' . $this->order_id. '<br>'.
      		$this->getAttributeLabel('create_time'). ': ' . date("Y-m-d", $this->create_time). '<br>'.
      		$this->getAttributeLabel('total_fee'). ': ' . $data->total_fee;
    	return $detail;
    }

    protected function beforeSave() {
        $orderLog = new OrderLog();
        if ($this->isNewRecord) {
            $orderLog->op_name = 'create';
            $orderLog->log_text = serialize($this->attributes);
        } else {
            $orderLog->op_name = 'update';
            $orderLog->log_text = serialize($this->findByPk($this->order_id));
        }
        $orderLog->order_id = (int)$this->order_id;
        $this->orderLog = $orderLog;
        parent::beforeSave();
        return true;
    }

    protected function afterSave() {
        $this->orderLog->result = 'success';
        $this->orderLog->isNewRecord = true;
        if(!$this->orderLog->save()){
            return false;
        }
       parent::afterSave();
       return true;
    }

    protected function afterDelete()
    {
        $orderLog = new OrderLog();
        $orderLog->op_name = 'delete';
        $orderLog->log_text = serialize($this);
        $orderLog->order_id = $this->order_id;
        $orderLog->result = 'success';
        $orderLog->save();
    }

    public function MyOrderSearch(){
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('user_id', Yii::app()->user->id, true);
        $criteria->compare('t.status', $this->status);
        //$criteria->compare('pay_status', $this->pay_status);
       // $criteria->compare('refund_status', $this->refund_status);
        $criteria->compare('review_status', $this->review_status);
        $criteria->compare('total_fee', $this->total_fee, true);
        $criteria->compare('pay_fee', $this->pay_fee, true);
        $criteria->compare('payment_method_id', $this->payment_method_id, true);
        //$criteria->compare('receiver_name', $this->receiver_name, true);
       // $criteria->compare('receiver_country', $this->receiver_country, true);
       // $criteria->compare('receiver_state', $this->receiver_state, true);
       // $criteria->compare('receiver_city', $this->receiver_city, true);
       // $criteria->compare('receiver_district', $this->receiver_district, true);
        //$criteria->compare('receiver_address', $this->receiver_address, true);
      //  $criteria->compare('receiver_zip', $this->receiver_zip, true);
       // $criteria->compare('receiver_mobile', $this->receiver_mobile, true);
      //  $criteria->compare('receiver_phone', $this->receiver_phone, true);
      //  $criteria->compare('memo', $this->memo, true);
        $criteria->compare('pay_time', $this->pay_time, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);

        $criteria->with = 'users';
        $criteria->order='order_id desc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}