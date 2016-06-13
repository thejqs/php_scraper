#A scraper! In PHP!#

A first attempt to scrape a website using **PHP** -- a language I have never used before in my life.

I mean is this fun or what.

*To get started:*
```php
function openURL($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
```

*And the bookend, handling the database dump:*
```php
function storeData($conn_string, $objs) {
    $db = pg_connect($conn_string);
    if ($db) {
        echo 'connected';
        foreach($objs as $obj) {
            $result = pg_query($db, "INSERT INTO stores(store_id, address, phone, latitude, longitude)
                                VALUES('$obj->storeID', '$obj->address', '$obj->phone', $obj->latitude, $obj->longitude);");
            var_dump($result);
        }
    }
    else {
        echo 'failed to connect';
    }
    pg_close($db);
}
```

Hey, look at that.

![alt text][db]

[db]: https://github.com/thejqs/php_scraper/blob/master/psql_screenshot.png
