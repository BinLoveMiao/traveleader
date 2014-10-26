<?php

/**
 * position in the cart
 *
 * @author pirrat <mrakobesov@gmail.com>
 * @version 0.9
 * @package ShoppingCart
 *
 * Can be used with non-AR models.
 */
class ECartPositionBehaviour extends CActiveRecordBehavior {

    /**
     * Positions number
     * @var int
     */
    private $quantity = 0;
    
    private $adult_number = 0;
    private $child_number = 0;
    private $price_adult = 0;
    private $price_child = 0;
    /**
     * Update model on session restore?
     * @var boolean
     */
    private $refresh = true;

    /**
     * Position discount sum
     * @var float
     */
    private $discountPrice = 0.0;

    /**
     * Returns total price for all units of the position
     * @param bool $withDiscount
     * @return float
     *
     */
    public function getSumPrice($withDiscount = true) {
    	if($this->price_adult != 0 && $this->price_child != 0){
    		$fullSum = $this->price_adult * $this->adult_number +
    						$this->price_child * $this->child_number;
    	}
    	else{
       		$fullSum = $this->getOwner()->getPrice() * $this->quantity;
    	}
        if($withDiscount)
            $fullSum -=  $this->discountPrice;
        return $fullSum;
    }

    /**
     * Returns quantity.
     * @return int
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Updates quantity.
     *
     * @param int quantity
     */
    public function setQuantity($newVal) {
        $this->quantity = $newVal;
    }
    
    public function getChildNumber(){
    	return $this->child_number;
    }
    
    public function setChildNumber($num){
    	$this->child_number = $num;
    }
    
    public function getAdultNumber(){
    	return $this->adult_number;
    }
    
    public function setAdultNumber($num){
    	$this->adult_number = $num;
    }
    
    public function getChildPrice(){
    	return $this->price_child;
    }
    
    public function setChildPrice($price){
    	$this->price_child = $price;
    }
    
    public function getAdultPrice(){
    	return $this->price_adult;
    }
    
    public function setAdultPrice($price){
    	$this->price_adult = $price;
    }
    

    /**
     * Magic method. Called on session restore.
     */
    public function __wakeup() {
        if ($this->refresh === true)
            $this->getOwner()->refresh();
    }

    /**
     * If we need to refresh model on restoring session.
     * Default is true.
     * @param boolean $refresh
     */
    public function setRefresh($refresh) {
        $this->refresh = $refresh;
    }

    /**
     * Add $price to position discount sum
     * @param float $price
     * @return void
     */
    public function addDiscountPrice($price) {
        $this->discountPrice += $price;
    }

    /**
     * Set position discount sum
     * @param float $price
     * @return void
     */
    public function setDiscountPrice($price) {
        $this->discountPrice = $price;
    }
}
