<?php
//此php文件为下载并解压index.php获取的down的链接的演示
//有bug请自行修改，都有注解
require_once 'get302.php';//引入获取302跳转后的链接
//移除文件夹函数
function recursiveDirectoryDelete($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir") {
                    recursiveDirectoryDelete($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}
//检测down参数
if(isset($_GET['down'])){
    //赋值down参数为$url
$url = $_GET['down'];
} else {
    //如果没有down参数
    echo "请GET提交down参数?dowm=你要下载的压缩包链接";
    die();
}
//获取302跳转后的真实下载链接
$rurl = get302($url);
//Chatgpt所写
$ch = curl_init();
//模拟header
$header = array(
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36',
);
// 设置cURL会话的参数
curl_setopt($ch, CURLOPT_URL, $rurl);

// 设置cURL会话的超时时间
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
// 设置cURL会话的返回类型
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//SLL配置检测应付
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//获取信息
$info = curl_getinfo($ch);
//preg_match('/filename=(.*)/', $result, $matches);
// 执行cURL会话
$result = curl_exec($ch);
// 检查是否有错误发生
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}
// 将old文件夹拷贝到test文件夹
// 参数说明：
//   $source：源目录名
//   $dest：目的目录名
function copydir($source, $dest){
    if (!file_exists($dest)) {
        mkdir($dest);
    }
    $handle = opendir($source);
    while (($item = readdir($handle)) !== false) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        $_source = $source . '/' . $item;
        $_dest = $dest . '/' . $item;
        if (is_file($_source)) {
            copy($_source, $_dest);
        }
        if (is_dir($_source)) {
            copydir($_source, $_dest);
        }
    }
    closedir($handle);
}
// 关闭cURL会话
curl_close($ch);
// 使用PHP的文件函数将下载的文件保存到本地
file_put_contents('./file.zip', $result);
// 要解压的文件路径
$file = './file.zip';

// 创建ZipArchive对象
$zip = new ZipArchive;

// 打开zip文件
if ($zip->open($file) === TRUE) {
    // 解压到zip文件夹，方便对其进行操作
    $zip->extractTo('./zip/');
    // 关闭zip文件
    $zip->close();
    echo '文件解压成功';
    $dir = 'zip';
    $files = scandir($dir);
    $firstDir = $files[2];
    //原来的文件夹内的第一个文件夹
    $source = $dir.'/'.$firstDir;
    //目标文件夹
    $dest = '../';
    // 创建目标文件夹
    if(!is_dir($dest)) {
        mkdir($dest);
    }
    // 复制文件
    copydir($source,$dest);
    // 删除file.zip
    unlink('file.zip');
    //删除zip文件夹
    recursiveDirectoryDelete('zip');
} else {
    //失败
    echo '文件解压失败';
}

echo ' 更新完成';
echo <<<EOF
<script>
setTimeout(function(){
    window.location.href="../";
},1000);
</script>
EOF;
?>
