<?php
//更新本地版本号为最新版本，更改.version文件
if (isset($_GET['version'])) {
    $version = $_GET['version'];
    // do something with $version
} else {
    echo "缺少version参数";
    // stop execution
    exit;
}

$version = strtotime($version);
$file = '.version';
if (file_put_contents($file, $version)) {
    //pass
} else {
    die('写入失败');
}