<?php
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$request_uri = $_SERVER['REQUEST_URI'];

// Get the directory path from the REQUEST_URI
$folder_path = dirname($request_uri);

// Construct the complete URL for the folder
$folder_url = $protocol . $host . $folder_path;

echo $folder_url;
?>