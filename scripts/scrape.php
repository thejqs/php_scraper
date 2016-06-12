#!usr/bin/env php

<?php
include('config.php');
include('object.php');

// open url
function getHTML($url) {
    // initialize curl resource
    $ch = curl_init();
    // provide url
    curl_setopt($ch, CURLOPT_URL, $url);
    // stringify response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // follow any redirects (shouldn't be any, but just in case)
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // store response string
    $response = curl_exec($ch);
    // close curl resource
    curl_close($ch);

    return $response;
}

// properly format the HTML for XML parsing
function handleBrokenHTML($html) {
    $old = libxml_use_internal_errors(true);
    $dom = new DOMDocument;
    $dom->loadHTML($html);
    libxml_use_internal_errors($old);
    return $dom;
}

// turns our html into a traversable DOM
function parseHTML($url) {
    $html = getHTML($url);
    // php says this is some broken-ass html
    // attemtping to repair enough to make usable
    $dom = handleBrokenHTML($html);
    return simplexml_import_dom($dom);
}

// collect an array of store ids
function getStoreIDs($xmlObj) {
    $storeIDs = $xmlObj->xpath('//*[@id="main_container"]/div[4]/div/div[2]/span[2]/text()');
    $cleanIDs = array_map(function($x) {return trim($x);}, $storeIDs);
    return $cleanIDs;
}

// collect and array of addresses
function getAddresses($xmlObj) {
    return $xmlObj->xpath('//*[@id="main_container"]/div[4]/div/div[5]/form/input[3]/@value');
}

// collect an array of phone numbers
function getPhone($xmlObj) {
    return $xmlObj->xpath('//*[@id="main_container"]/div[4]/div/div[5]/form/input[4]/@value');
}

// collect an array of latitudes
function getLatitudes($xmlObj) {
    return $xmlObj->xpath('//*[@id="main_container"]/div[4]/div/div[5]/form/input[2]/@value');
}

//collect an array of longitudes
function getLongitudes($xmlObj) {
    return $xmlObj->xpath('//*[@id="main_container"]/div[4]/div/div[5]/form/input[1]/@value');
}

// returns array-ified data ready to become objects
function getData($url) {
    $xml = parseHTML($url);
    $storeIDs = getStoreIDs($xml);
    $addresses = getAddresses($xml);
    $phoneNumbers = getPhone($xml);
    $latitudes = getLatitudes($xml);
    $longitudes = getLongitudes($xml);
    $latLng = combineLatLng($latitudes, $longitudes);
    return sortData($storeIDs, $addresses, $phoneNumbers, $latLng);
}

// latitude and longitude are of necessity collected separately;
// don't want to lose track of them of have them change order
function combineLatLng($lat, $lng) {
    return array_map(null, $lat, $lng);
}

function sortData($listOne, $listTwo, $listThree, $listFour) {
    return array_map(null, $listOne, $listTwo, $listThree, $listFour);
}

// for object assembly, expects arrays in $sortedData
// to be ordered like this:
// [0]: store id
// [1]: address
// [2]: phone
// [3]: [0]:latitude, [1]:longitude
function buildObjects($sortedData) {
    $stores = array();
    foreach($sortedData as $store) {
        $newStore = new Store((string)$store[0], (string)$store[1][0], (string)$store[2][0], floatval($store[3][0][0]), floatval($store[3][1][0]));
        array_push($stores, $newStore);
    }
    print_r($stores);
}

function scrape($url) {
    $data = getData($url);
    buildObjects($data);
}

scrape($url);

// store cleaned response
?>
