

<?php
//302跳转获取
function get302($url)
{
    //获取302跳转后的真实地址的真正唯一方法！！！！！
    //$url = 'https://api.github.com/repos/hllqk/hllqk.github.io/zipball/api1.0';

    $curl = curl_init();
    $header = array(
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36',
    );
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    $response = curl_exec($curl);
    //print_r($response);
    $info = curl_getinfo($curl);
    curl_close($curl);
    $retURL = $info['url'];
    return $retURL;
}
?>