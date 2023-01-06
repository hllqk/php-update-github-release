<html>
<head>
<meta charset="utf-8">
<title>更新</title>
<!-- 更新主程序 -->
<!-- <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"> -->
</script>
</head>
<body>
<form id="form1" action="get.php" method="get">
https://api.github.com/repos/<input id="user" type="text" value="" name="user">/
<input id="repo" value="" type="text" name="repo">
 <input type="submit" value="检测更新"><input onclick="更新时间 = document.getElementById('updatetime').innerHTML;var xhrr = new XMLHttpRequest();xhrr.open('GET', 'creatversion.php?' +'version='+更新时间);xhrr.send();document.getElementById('downurl').click()" id="update" type="submit" value="立即更新" style="display:none;" />
</form>
<style>
    input{
        font-size: medium;
        width: 100px;
    }
</style>
<p style="display:none;" id="updatetime"></p>
<a style="display:none;" id="downurl" href="repo" >Download</a>
<h4 id="needed"></h4>
<script type="text/javascript">
  document.getElementById('form1').onsubmit = function(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
      if(xhr.readyState == 4){
        if(xhr.responseText=='当前是最新版本')
        {
            document.getElementById('needed').innerHTML = xhr.responseText;
           return 
        }
        document.getElementById('needed').innerHTML = xhr.responseText;
        document.getElementById("update").style.display = "block";
        var jsonData = JSON.parse(xhr.responseText);
        更新时间=jsonData.更新时间
        // alert(更新时间)
        document.getElementById('updatetime').innerHTML = 更新时间;
        下载链接=jsonData.下载链接
        downurl.href = 'down.php?down='+下载链接;
      }
    }
    user=new FormData(this).get("user")
    repo=new FormData(this).get("repo")
    var downurl = document.getElementById('downurl');
     //document.getElementsByName
    xhr.open('GET', 'get.php?' +'user='+user+'&repo='+repo)
    xhr.send();
    return false;
  }

</script>

<?php
require_once 'config.php';
if(isset($_GET['access'])){
  if(md5($_GET['access'])==$password)
  {
//pass
        echo <<<EOF
        <script>
        document.getElementById("user").value ='$user';
        document.getElementById('repo').value ="$repo";
        </script>
        EOF;
  }
  else
  {
    header("location:./403.php");
  }
}
else{
  echo <<<EOF
  
<script>
if('$password'!='')
{
var password = prompt("请输入密码：");
window.location.href = "./?access="+password;
}


</script>
EOF;
}
?>

</body>
</html>
