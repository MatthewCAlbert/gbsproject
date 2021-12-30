<?php
    //error_reporting(0);
    session_start();
    header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    $main_directory = "http://192.168.100.14/gbsapp/";
    $api_directory = 'http://192.168.100.14/gbs-api/';
    //$api_directory = 'https://api.gbsproject.com/';
    $main_title = " - GBS eMoney App";
    $cookie_dir = "/";
    $secure_https = FALSE;
    $http_only = TRUE;