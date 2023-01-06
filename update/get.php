<?php
//获取仓库最新版本的详细信息
header('Content-Type: application/json; charset=utf-8');
if (!empty($_GET['user']) && !empty($_GET['repo'])) {
    $user=$_GET['user'];
    $repo=$_GET['repo'];
} else {
    die('参数user和repo不完整');
}
$url = "https://api.github.com/repos/$user/$repo/releases/latest";
//die($url);
$header = array(
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36',
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$output = curl_exec($ch);
curl_close($ch);
$data = json_decode($output, true);
 
$body = $data['body'];
$zipball_url = $data['zipball_url'];
$tag_name = $data['tag_name'];
$published_at = $data['published_at'];
// echo strtotime (date("y-m-d h:i:s"));;
// echo '<br>';
$getv=strtotime($published_at);//获取的版本
$myfile = fopen(".version", "r") or die("Unable to open file!");
$locv=fread($myfile,filesize(".version"));//当地版本
fclose($myfile);
if($locv<$getv){
    //echo '需要更新';
   }
else{
    die('当前是最新版本');
   }
//echo $zipball_url;
$body = str_replace("\r", "", $body);
$body = str_replace("\n", "<br>", $body);
$json = array(
    "更新内容" => $body,
    "下载链接" => $zipball_url,
    "标签" => $tag_name,
    "更新时间" => $published_at
);

echo json_encode($json,JSON_UNESCAPED_UNICODE);
//echo $zipball_url;