
#!usr/bin/env php

<?php
include('config.php');
include('object.php');

// open url
function openURL($url) {
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

    echo $response;
    return $response;
}

openURL($url);


// parse response

// clean response

// store cleaned response
?>
