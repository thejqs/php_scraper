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

function getData($url) {
    $xml = parseHTML($url);
    $storeIDs = getStoreIDs($xml);
    $addresses = getAddresses($xml);
    $phoneNumbers = getPhone($xml);
    $latitudes = getLatitudes($xml);
    $longitudes = getLongitudes($xml);
    return sortData($storeIDs, $addresses, $phoneNumbers, $latitudes, $longitudes);
}

function sortData($listOne, $listTwo, $listThree, $listFour, $listFive) {
    $zipFirst = array_map(null, $listFour, $listFive);
    return array_map(null, $listOne, $listTwo, $listThree, $zipFirst);
}

getData($url);

// store cleaned response
?>
