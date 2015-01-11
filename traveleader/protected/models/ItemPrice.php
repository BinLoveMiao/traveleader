<?php

/**
 * This is the model class for table "item_price".
 *
 * The followings are the available columns in table 'item_price':
 * @property string $item_price_id
 * @property string $item_id
 * @property string $date // Begin Date
 * @Property string $end_date // End Date
 * @property string $price_adult
 * @property string $price_child
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property ItemPrice $item_price
 */
class ItemPrice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('item_id, date, price_adult, price_child', 'required'),
				array('item_id', 'length', 'max'=>10),
				array('price_adult, price_child', 'length', 'max'=>10),
				array('date, end_date', 'date', 'format'=>'yyyy-mm-dd'),
				array('end_date, create_time, update_time', 'safe'),
				// The following rule is used by search().
				// @todo Please remove those attributes that should not be searched.
				array('item_price_id, item_id, date, create_time, update_time', 'safe', 'on'=>'search'),
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
				'item' => array(self::BELONGS_TO, 'Item', 'item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'item_price_id' => 'Item Price',
				'item_id' => Yii::t('item', 'item_id'),
				'date' => Yii::t('item', 'begin_date'),
				'end_date' => Yii::t('item', 'end_date'),
				'date_type' => Yii::t('item', 'date_type'),
				'date_range' => Yii::t('item', 'date_range'),
				'date_single' => Yii::t('item', 'date_single'),
				'price_adult' => Yii::t('item', 'price_adult'),
				'price_child' => Yii::t('item', 'price_child'),
				'create_time' => Yii::t('main', 'Create Time'),
				'price_calendar' => Yii::t('item', 'price_calendar'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('item_price_id',$this->item_price_id,true);
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('date',$this->date);
		$criteria->compare('price_adult',$this->price_adult,true);
		$criteria->compare('price_child',$this->price_child,true);
		$criteria->compare('create_time', $this->create_time, true);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	/**
	 * Accept $itemPrices for specific item, 
	 * return the formatted item calendar for calendar display.
	 * Specific day may exist in several $itemPrices, in the form
	 * or either date_range or date_single. If both exist, we tend to
	 * use date_single. 
	 * @param array[ItemPrice] $itemPrices
	 * @param integer $day_limit
	 * @param string $currency
	 */
	public static function getPriceCalendar($itemPrices, $day_limit=60, $currency='￥'){
		$tomorrow =  (new DateTime('tomorrow'))->format('Y-m-d');
		// First, indentify data_single itemPrice
		$singleDatePrices = array();
		//$prices[] = array();
		foreach($itemPrices as $item_price){
			if($item_price->date == $item_price->end_date){
				if(!empty($singleDatePrices[strtotime($item_price->date)])){
					continue;
				}
				$singleDatePrices[strtotime($item_price->date)] = array(
						'price_id' => $item_price->item_price_id,
						'title'=>''.$currency.$item_price->price_adult,
						'start'=>''.$item_price->date,
						'color'=>'gray',
						'description'=>Yii::t('main', 'adult').':'.$currency.
							$item_price->price_adult. '; '. Yii::t('main', 'child').
							':'. $currency.$item_price->price_child,
				);
			}
		}
		$secsPerDay = 3600 * 24;
		foreach($itemPrices as $item_price){
			//print_r($item_price);
			$begin_date = $item_price->date;
			$end_date = $item_price->end_date;
			
			if($begin_date == $end_date){
				continue;
			}
			$begin_date = (strtotime($begin_date) - strtotime($tomorrow) < 0) ?  
				strtotime($tomorrow) : strtotime($begin_date);
			$end_date = (strtotime($end_date) - (strtotime($tomorrow) + $secsPerDay * $day_limit) < 0 ? 
				strtotime($end_date) : (strtotime($tomorrow) + $secsPerDay * $day_limit));
			
						
			for($d = $begin_date - $secsPerDay; $d <= $end_date;){
				$d += $secsPerDay;	
				if($singleDatePrices[$d]){
					$prices[$d] = $singleDatePrices[$d];
					$singleDatePrices[$d] = 0;
					continue;
				}
				if(!empty($prices[$d])){
					continue;
				}
				$prices[$d]=array(
						'price_id' => $item_price->item_price_id,
						'title'=>''.$currency.$item_price->price_adult,
						'start'=>date('Y-m-d', $d),
						'color'=>'#42B312',
						'description'=>Yii::t('main', 'adult').':'.$currency.
							$item_price->price_adult. ';'. Yii::t('main', 'child').
							':'. $currency. $item_price->price_child,
				);
			}
		}
		foreach($singleDatePrices as $d=>$single){
			if($single != 0){
				$prices[$d] = $single;
			}
		}
		if(count($prices) > 0){
			foreach($prices as $id => $value){
				$price_cal[] = $value;
			}
		}
		return $price_cal;
	}
	
	/**
	 * Get Price List from Item_Prices for droplist
	 * @param unknown $itemPrices
	 * @param number $day_limit
	 * @param string $currency
	 */
	public static function getPriceList($price_cal, $day_limit=20){
		$price_list = array();
		if(count($price_cal) == 0){
			return $price_list;
		}
		$i = 0;
		foreach($price_cal as $price){
			if($i > $day_limit){
				break;
			}
			else{
				$price_list[$price["price_id"] . "|" . $price['start']] = $price['start']. " | " . $price['description'];
			}
			$i += 1;
		}
		return $price_list;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemImg the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
	{
		$this->create_time = time();
		return parent::beforeSave();
	}

}