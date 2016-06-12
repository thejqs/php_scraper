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

function cleanHTML($html) {
    $old = libxml_use_internal_errors(true);
    $dom = new DOMDocument;
    $dom->loadHTML($html);
    libxml_use_internal_errors($old);
    return $dom;
}

function getStoreIDs($xml) {
    return $xml->xpath('//*[@id="main_container"]/div[4]/div/div[2]/span[2]/text()');
}

// parse response
function parseHTML($url) {
    $html = getHTML($url);
    // php says this is some broken-ass html
    // attemtping to repair enough to make usable
    $dom = cleanHTML($html);
    $xml = simplexml_import_dom($dom);
    $storeIDs = getStoreIDs($xml);
    echo trim($storeIDs[0]);
}

parseHTML($url);

// clean response

// store cleaned response
?>
