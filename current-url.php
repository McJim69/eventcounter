<?php
// Determine the protocol (http or https)
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Get the host name
$host = $_SERVER['HTTP_HOST'];

// Get the request URI (path and query string)
$requestUri = $_SERVER['REQUEST_URI'];

// Construct the full URL
$currentUrl = $protocol . $host . $requestUri;

echo $currentUrl;
?>