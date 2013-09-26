<?php

function getTwitterCount() {
    $url = get_permalink();
    $json_string = file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url='.$url);
    $json = json_decode($json_string, true);
     return intval($json['count']);
}

function getFacebookCount() {
    $url = get_permalink();
    $addr="http://api.facebook.com/restserver.php?method=links.getStats&urls=".$url;
    $page_source=file_get_contents($addr);
    $page = htmlentities($page_source);
    $like="<like_count>";
    $like1="</like_count>";
    $lik=strpos($page,htmlentities($like));
    $lik1=strpos($page,htmlentities($like1));
    $fullcount=strlen($page);
    $a=$fullcount-$lik1;
    $aaa=substr($page,$lik+18,-$a);
    $aaa1=substr($page,605,610);

    return $aaa;
}

function getStumbleCount() {
    $url = get_permalink();
    $json_string = file_get_contents('http://www.stumbleupon.com/services/1.01/badge.getinfo?url='.$url);
    $json = json_decode($json_string, true);
     return intval($json['result']['views']);
}

function getLinkedinCount() {
     $url = get_permalink();
    $json_string = file_get_contents('http://www.linkedin.com/countserv/count/share?url='.$url.'&format=json');
    $json = json_decode($json_string, true);
    return intval($json['count']);
 
}

function getPinterestCount() {
    $url = get_permalink();
    $json_string = file_get_contents( 'http://api.pinterest.com/v1/urls/count.json?callback=receiveCount&url='.$url);
    $raw_json = preg_replace('/^receiveCount\((.*)\)$/', "\\1", $json_string);
    $json = json_decode($raw_json, true);
    return intval( $json['count'] );
}

function getGooglePlusCount() {
    $url = get_permalink();
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
      $curl_results = curl_exec ($curl);
      curl_close ($curl);
      $json = json_decode($curl_results, true);
      return intval( $json[0]['result']['metadata']['globalCounts']['count'] );
}

function getSocialCount() {
    return getTwitterCount() + getFacebookCount() + getLinkedinCount() + getPinterestCount() + getGooglePlusCount();
}

?>