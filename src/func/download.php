<?php
    require_once "../config.php";
    @$name = $_GET['name'];
    $res = '.' . $res;
    if (is_dir($res)) {
        $list = scandir($res);
    } else {
        die('漫画储存路径无法访问或不存在！');
    }
    if (!in_array($name, $list)) {
        die('漫画储存路径无法访问或不存在！');
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>下载中...</title>
    <link rel="stylesheet" href="../static/css/load.css">
</head>
<body>
<h3>文件打包中，打包完成后自动下载</h3>
<div class='loading'></div>
<h3>请耐心等待一段时间</h3>
<iframe src='./down.php?name=<?php echo $_GET['name']?>' width="0" height="0"></iframe>
</body>
</html>