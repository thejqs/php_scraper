#A scraper! In PHP!#

A first attempt to scrape a website using **PHP** -- a language I have *never* used before in my life.

I mean is this fun or what.

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


