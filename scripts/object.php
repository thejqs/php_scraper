<?php
class Store {
    public $storeID;
    public $address;
    public $phone;
    public $latitude;
    public $longitude;

    public function __construct($storeID, $address, $phone, $latitude, $longitude) {
        $this->storeID = $storeID;
        $this->address = $address;
        $this->phone = $phone;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}
?>
