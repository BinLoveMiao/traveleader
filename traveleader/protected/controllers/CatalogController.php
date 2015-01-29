<?php

class CatalogController extends YController
{
    public function actionIndex()
    {
        $cat = isset($_GET['cat']) ? $_GET['cat'] : 3;
        $category = is_numeric($cat) ? Category::model()->findByPk($cat) : Category::model()->findByAttributes(array('url' => $cat));
        if (empty($category) || $category->root != 3) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $criteria = new CDbCriteria();
        if($category->level != 1){
        	$descendantIds = $category->getDescendantIds();
        	$criteria->addInCondition('category_id', $descendantIds);
        	$this->breadcrumbs = array_merge($this->breadcrumbs, array($category->name
        			=> Yii::app()->createUrl('catalog/index', array('cat' => $category->getUrl()))));
        }
	     
        if(!empty($_GET['country'])){
        	$criteria->addCondition("t.country =".$_GET['country']);
        	$country = Area::loadModel($_GET['country']);
        	//$this->breadcrumbs[] = array('name' => $country->name. "旅游" .'>> ',
        	//		'url' => Yii::app()->createUrl('catalog/index', array('country' => $country->area_id)));
        }
        if(!empty($_GET['state'])){
        	$criteria->addCondition("t.state=".$_GET['state']);
        	$state = Area::loadModel($_GET['state']);
        	//$country = Area::model()->findByPk($state->parent_id);
        	$country = $state->parentArea;
        	//$this->breadcrumbs[] = array('name' => $country->name. "旅游" .'>> ',
        	//		'url' => Yii::app()->createUrl('catalog/index', array('country' => $country->area_id)));
        	//$this->breadcrumbs[] = array('name' => $state->name. "旅游" .'>> ',
        	//		'url' => Yii::app()->createUrl('catalog/index', array('state' => $state->area_id)));
        }
        if(!empty($_GET['city'])){
        	$criteria->addCondition("t.city =".$_GET['city']);
        	$city = Area::loadModel($_GET['city']);
        	//$state = Area::model()->findByPk($city->parent_id);
        	$state = $city->parentArea;
        	//$country = Area::model()->findByPk($state->parent_id);
        	$country = $state->parentArea;
        }
        if(!empty($_GET['scenery'])){
        	$criteria->addCondition("t.scenery_id =".$_GET['scenery']);
        	$scenery = Scenery::loadModel($_GET['scenery']);
        	$city = $scenery->cityArea;
        	$state = $scenery->stateArea;
        	$country = $scenery->countryArea;
        }
        
        if($country){
        	if($country->name != Yii::t('main', 'China')){        		    		
        		$this->breadcrumbs = array($country->name. Yii::t('main', 'travel') 
        			 => Yii::app()->createUrl('catalog/index', array(
        			 		'country' => $country->area_id)));
        	}
        }
        if($state){
        	$this->breadcrumbs = array_merge($this->breadcrumbs, array($state->name. Yii::t('main', 'travel')
        		=> Yii::app()->createUrl('catalog/index', array(
        				'state' => $state->area_id))));
        }
        if($city){
        	$this->breadcrumbs = array_merge($this->breadcrumbs, array($city->name. Yii::t('main', 'travel')
        		 => Yii::app()->createUrl('catalog/index', array('city' => $city->area_id))));
        }
        
        if($scenery){
        	$this->breadcrumbs = array_merge($this->breadcrumbs, array($scenery->name
        			=> Yii::app()->createUrl('catalog/index', array('scenery' => $scenery->id))));
        }
        
        //if(!empty($_GET['tag'])){
        //	$criteria->addCondition("t.tag1 = '{$_GET['tag']}' 
        //			OR t.tag2 = '{$_GET['tag']}'
        //			OR t.tag3 = '{$_GET['tag']}'");
        //	$tag=MoodTag::model()->findByPk($_GET['tag']);
        //	$tag->frequency += 1;
        ////	$tag->save();
      //  }

        if (!empty($_GET['key'])) {
            $criteria->addCondition("(t.title LIKE '%{$_GET['key']}%')");
        }
        if(!empty($_GET['floor_price'])&&!empty($_GET['top_price'])&&$_GET['top_price']<$_GET['floor_price']) {
            $criteria->addCondition("t.price >= '{$_GET['top_price']}'");
            $criteria->addCondition("t.price <= '{$_GET['floor_price']}'");
        } else {
            if (!empty($_GET['floor_price'])) {
                $criteria->addCondition("t.price >= '{$_GET['floor_price']}'");
            }
            if (!empty($_GET['top_price'])) {
                $criteria->addCondition("t.price <= '{$_GET['top_price']}'");
            }
        }
        if (!empty($_GET['has_stock']) && $_GET['has_stock']) {
            $criteria->addCondition("t.stock > 0");
        }
        if (!empty($_GET['sort'])) {
            switch ($_GET['sort']) {
                case 'sold':
                    break;
                case 'soldd':
                    break;
                case 'price':
                    $criteria->order = 't.price';
                    break;
                case 'priced':
                    $criteria->order = 't.price desc';
                    break;
                case 'new':
                    $criteria->order = 't.update_time';
                    break;
                case 'newd':
                    $criteria->order = 't.update_time desc';
                    break;
                default:
                    $criteria->order = 't.click_count desc';
                    break;
            }
        }
        else{
        	$criteria->order = 't.click_count desc';
        }

        $count = Item::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize =8;
        $pager->applyLimit($criteria);

        $items = Item::model()->findAll($criteria);
//        var_dump($criteria);die;
        $parentCategories = $category->parent()->findAll();
        $parentCategories = array_reverse($parentCategories);
        $categoryIds = array($category->category_id);
        $params = array();
        if (!empty($_GET['key'])) {
            $params['key'] = $_GET['key'];
        }
        //foreach ($parentCategories as $cate) {
        //    if (!$cate->isRoot()) {
        //        $params['cat'] = $cate->getUrl();
        //        $this->breadcrumbs[] = array('name' => $cate->name . '>> ', 'url' => Yii::app()->createUrl('catalog/index', $params));
        //        $categoryIds[] = $cate->category_id;
        //    }
        //}
        $params['cat'] = $category->getUrl();
        //$this->breadcrumbs[] = array('name' => $category->name, 'url' => Yii::app()->createUrl('catalog/index', $params));
        Yii::app()->params['categoryIds'] = $categoryIds;

        $categories = $category->children()->findAll();
        $itemProps = ItemProp::model()->with('propValues')->findAll(new CDbCriteria(array('condition' => "t.`category_id` = $category->category_id AND t.`type` > 1")));
        $this->render('index', array(
            'cat' => $cat,
            'count' => $count,
            'category' => $category,
            'items' => $items,
            'pager' => $pager,
            'categories' => $categories,
            'itemProps' => $itemProps,
            'sort' => $_GET['sort'],
            'key' => $_GET['key'],
        ));
    }
}