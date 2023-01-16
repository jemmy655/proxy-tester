<?php

// Fetch list of proxies from website
$proxies = file_get_contents("https://www.proxy-list.download/api/v1/get?type=http");
$proxies = explode("\n", $proxies);

// Initialize arrays to store working and non-working proxies
$workingProxies = array();
$nonWorkingProxies = array();

foreach ($proxies as $proxy) {
    // Set up cURL session with proxy
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.finexca.com/en/exchange/spot/BTC-USDT");
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Send request and capture response
    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Check if the request was successful
    if ($statusCode == 200) {
        $workingProxies[] = $proxy;
    } else {
        $nonWorkingProxies[] = $proxy;
    }

    // Close cURL session
    curl_close($ch);
}

// Print out list of working proxies
print_r($workingProxies);

// Print out list of non-working proxies
print_r($nonWorkingProxies);

?>
