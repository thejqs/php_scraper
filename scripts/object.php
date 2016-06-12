#!usr/bin/env php

<?php
class Store {
    public $storeID;
    public $address;
    public $phone;
    public $hours;

    public function __construct($storeID, $address, $hours, $phone) {
        $this->storeID = $storeID;
        $this->address = $address;
        $this->phone = $phone;
        $this->hours = $hours;
    }
}
?>
