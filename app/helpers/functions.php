<?php

if (!function_exists('pr')) {

    function pr($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

}

if (!function_exists('removeSchemaUrl')) {

    function removeSchemaUrl($domain) {
        if (empty($domain)) {
            return '';
        }
        $domain = trim($domain);
        $domain = str_replace(array('http://www.', 'https://www.', 'http://', 'https://', 'www.'), '', $domain);
        $domain = rtrim($domain, "/");
        return $domain;
    }

}