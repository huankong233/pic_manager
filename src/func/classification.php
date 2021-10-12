<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>分类</title>
    <link rel="stylesheet" href="../static/css/index.css">
    <link rel="stylesheet" href="../static/css/load.css">
    <link rel="stylesheet" href=../static/css/main.css>
    <link rel="stylesheet" href=../static/css/650.css>
    <link rel="stylesheet" href=../static/css/460.css>
    <link rel="stylesheet" href=../static/css/950.css>
    <link rel="stylesheet" href=../static/css/1250.css>
    <link rel="stylesheet" href=../static/css/1450.css>

</head>
<body style="background-color: #444444;">
<div class='nav_top'>
    <ul class='nav'>
        <li><a href='../'>首页</a></li>
        <li><a href='#'>分类</a></li>
        <li><a href='https://dl.huankong.top'>里番</a></li>
        <li><a href='https://www.huankong.top'>幻空仓库</a></li>
        <li><a href='https://www.huankong.top/sjgj'>司机工具</a></li>
    </ul>
</div>
<div class='body'>
    <form action='../index.php'>
        <input class='search' type='text' placeholder='搜索分类' name='sort'>
        <input class='submit' type='submit' value='提交'>
    </form>
    <form action='../func/search.php'>
        <input class='search' type='text' placeholder='搜索名称' name='name'>
        <input class='submit' type='submit' value='提交'>
    </form>
</div>
<div class='nav_bottom_place'>
    <ul class='nav_bottom'>
        <?php
            require_once '../config.php';
            $res = "../".$res;
            if (is_dir($res)) {
                $list = scandir($res);
                for ($i = 0; $i <= count($list) - 1; $i++) {
                    if ($list[$i] !== '.' && $list[$i] !== '..') {
                        $pic_path = $res . '/' . $list[$i];
                        if (is_dir($pic_path)) {
                            $arr[$list[$i]] = scandir($pic_path);
                        }
                    }
                }
            } else {
                die('漫画储存路径无法访问或不存在！');
            }
            $save = [];
            for ($i = 0; $i < count($list); $i++) {
                if ($list[$i] !== '.' && $list[$i] !== '..') {
                    $path = $res . '/' . $list[$i];
                    if (is_dir($path)) {
                        @$txt = file_get_contents($res . '/' . $list[$i] . '/' . $classify);
                        if ($txt != false) {
                            $arr = explode("\n", $txt);
                            for ($k = 0; $k < count($arr); $k++) {
                                $link = '../index.php?sort=' . $arr[$k];
                                if (!in_array($arr[$k],$save)){
                                    $save[]=$arr[$k];
                                    echo "<li><a href='$link'><p>{$arr[$k]}</p></a></li>";
                                }
                            }
                        }
                    }
                }
            }
        ?>
    </ul>
</div>
</body>
</html>