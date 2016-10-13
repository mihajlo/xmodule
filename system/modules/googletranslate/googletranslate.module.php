<?php

class googletranslate {

    function __construct() {
        $this->translate_url = 'https://translate.google.com/m?ie=UTF-8&prev=_m&hl=en&';
        $this->urlReferer = 'https://translate.google.com/m';
        $this->userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
    }
    
    public function index(){
        return $this;
    }

    public function translate($text, $to, $from = '') {
        $url = $this->translate_url . 'sl=' . $from . '&tl=' . $to . '&q=' . urlencode(@$text);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($ch, CURLOPT_REFERER, $this->urlReferer);
        curl_setopt($ch, CURLOPT_URL, $url);
        return $this->parseResponse(curl_exec($ch));
    }

    private function parseResponse($str = '') {
        $result = strip_tags($str, '<div>');
        $result = explode('<', substr($result, strpos($result, 'class="t0"') + 11, strpos($result, 'class="t0"')));
        $result = $result[0];
        return $result;
    }

}