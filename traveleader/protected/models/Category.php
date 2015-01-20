<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $category_id
 * @property string $left
 * @property string $right
 * @property string $root
 * @property string $level
 * @property string $name
 * @property integer $label
 * @property string $url
 * @property string $pic
 * @property string $pic2
 * @property integer $is_show
 *
 * The followings are the available model relations:
 * @property Item[] $items
 * @property ItemProp[] $itemProps
 */
class Category extends CActiveRecord
{
	public $parent;
	
	const LABEL_NONE = 0;
	const LABEL_NEW = 1;
	const LABEL_HOT = 2;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, label, is_show', 'required'),
            array('label, is_show', 'numerical', 'integerOnly' => true),
        	array('label', 'in', 'range'=>array(0,1,2)),
        	array('is_show', 'in', 'range'=>array(0,1)),
            //array('root', 'length', 'max' => 10),
            array('name, url', 'length', 'max' => 512),
            array('pic, pic2', 'length', 'max' => 512),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('name, label, url, is_show', 'safe', 'on' => 'search'),
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
            'items' => array(self::HAS_MANY, 'Item', 'category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'category_id' => Yii::t('category', 'category_id'),
            'left' => Yii::t('category', 'left'),
            'right' => Yii::t('category', 'right'),
            'root' =>  Yii::t('category', 'root'),
            'level' => Yii::t('category', 'level'),
            'name' =>  Yii::t('category', 'name'),
            'label' =>  Yii::t('category', 'label'),
            'url' =>  Yii::t('category', 'url'),
            'pic' =>  Yii::t('category', 'pic'),
        	'pic2' =>  Yii::t('category', 'pic2'),
            'is_show' =>  Yii::t('category', 'is_show'),
        	'parent' => Yii::t('category', 'parent'),
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

        $criteria = new CDbCriteria;
        //$criteria->compare('level', $this->level, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('label', $this->label);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('is_show', $this->is_show);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Category the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'NestedSetBehavior' => array(
                'class' => 'ext.nested-set-behavior.NestedSetBehavior',
                'leftAttribute' => 'left',
                'rightAttribute' => 'right',
                'levelAttribute' => 'level',
            	'rootAttribute' => 'root',
                'hasManyRoots' => true,
            ),
            'NestedSetExtBehavior' => array(
                'class' => 'ext.NestedSetExtBehavior',
                'id' => 'category_id',
            )
        );
    }

    /**
     * get label view
     * @return string
     * @author Lujie.Zhou(gao_lujie@live.cn, qq:821293064).
     */
    public function getLabel()
    {
        switch ($this->label) {
            case self::LABEL_NEW:
                return '<span class="label label-info" style="margin-right:5px">New</span>' . $this->name;
            case self::LABEL_HOT:
                return '<span class="label label-important" style="margin-right:5px">Hot!</span>' . $this->name;
            default:
                return $this->name;
                break;
        }
    }

    /**
     * get label list, use for editing category
     * @return array
     * @author Lujie.Zhou(gao_lujie@live.cn, qq:821293064).
     */
    public function getLabelList()
    {
        return array(
            '0' => '<span class="label label-success">None</span>',
            '1' => '<span class="label label-info">New</span>',
            '2' => '<span class="label label-important">Hot!</span>',
        );
    }

    public function getUrl()
    {
        return $this->url ? $this->url : $this->category_id;
    }

    public function scopes()
    {
        return array(
            'new' => array(
                'condition' => 't.label = '.self::LABEL_NEW
            ),
            'hot' => array(
                'condition' => 't.label = '.self::LABEL_HOT
            ),
        );
    }
    
    public function getImages(){
    	if(!empty($this->pic)){
    		$images[]=$this->pic;
    	}
    	if(!empty($this->pic2)){
    		$images[]=$this->pic2;
    	}
    	return $images;	
    }

    public function limit($limit = 3)
    {
        $this->getDbCriteria()->mergeWith(array(
            'limit' => $limit,
        ));
        return $this;
    }

    public function level($level = 2)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 't.level = ' . $level
        ));
        return $this;
    }
    
    /**
     * Return the maximal right value for the children. 
     * If current lavel is already the maximal level (3), we return -1 for exception process. 
     * @return number
     */
    public function currentMaxRightValue(){
    	if($this->level >= 3){
    		return -1;
    	}
    	else{
    		$max_right_value_child = $this->children()->findAll(array('order'=>'t.right DESC'))[0];
    		if(empty($max_right_value_child)){
    			return $this->left;
    		}
    		else{
    			return $max_right_value_child->right;
    		}
    	}
    }

    
    public function afterDelete(){
    	//$children = $this->children()->findAll();
    	//foreach($children as $child){
    	//	$child->delete();
    	//}
    	parent::afterDelete();
    }
}