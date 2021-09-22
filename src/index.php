<?php
    require_once "./config.php";
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
    if (count($list)==2){
        die('请在漫画储存文件夹内放入漫画文件夹');
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>首页</title>
    <link rel="stylesheet" href="./static/css/index.css">
    <link rel="stylesheet" href="./static/css/load.css">
    <style>
        .load{
            margin: 0 auto;
            background-color: white;
            position: absolute;
            top: 40%;
            font-size: 15px;
        }
    </style>
    <script src="https://lib.baomitu.com/jquery/latest/jquery.js"></script>
</head>
<body>
<div class="body">
        <div class='nav_top'>
            <ul class='nav'>
                <li><a href=''>首页</a></li>
                <li><a href=''>分类</a></li>
                <li><a href=''>里番</a></li>
                <li><a href=''>幻空仓库</a></li>
                <li><a href=''>幻空网盘</a></li>
            </ul>
        </div>
        <div class='nav_bottom_place'>
            <ul class='nav_bottom'>
                <li><a href=''>萝莉</a></li>
                <li><a href=''>巨乳</a></li>
                <li><a href=''>姐姐系</a></li>
                <li><a href=''>乱伦</a></li>
                <li><a href=''>人妻</a></li>
                <li><a href=''>小孩开大车</a></li>
                <li><a href=''>cg</a></li>
                <li><a href=''>查看更多</a></li>
            </ul>
        </div>
    <?php
        for ($i = 0; $i < count($list); $i++) {
            if ($list[$i] !== "." && $list[$i] !== "..") {
                $path = $res . '/' . $list[$i];
                if (is_dir($path)) {
                    $path_info = scandir($path);
                    for ($j=0;$j<count($path_info);$j++){
                        if (in_array($path_info[$j],$cover)){
                            $main_cover = $res."/".$list[$i]."/".$path_info[$j];
                        }else{
                            $main_cover = './static/icon/none.jpg';
                        }
                    }
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $type = finfo_file($finfo, $main_cover);
                    $info = file_get_contents($main_cover);
                    $main_cover = "./func/quality.php?q=".$q."&path=".$main_cover;
                    $base64String = 'data:' . $type . ';base64,' . chunk_split(base64_encode($info));
                    print "
                            <div class='pic'>
                                <a href='./func/detail.php?name=$list[$i]'>
                                    <img src='$base64String' alt='封面'>
                                    <p>$list[$i]</p>
                                </a>
                            </div>
                    ";
                }
            }
        }
    ?>
</div>
</body>
<script>
    $(".pic").click(function (){
        $("body").append("<div class='load'><div class='loading'></div><h1>如果你看见这个圈，说明你的浏览器正在预加载中,请耐心等待...</h1></div>");
    })
    window.addEventListener('pageshow',function (){
        if ($(".load").length===1){
            $(".load").remove();
        }
    })
    $(function() {
        initPageHistory();
        function initPageHistory() {
            window.addEventListener('pageshow', function (event) {
                if(event.persisted || window.performance && window.performance.navigation.type == 2){
                    console.log('window.performance.navigation.type: '+ window.performance.navigation.type);
                    window.location.reload();
                }
            },false);
        }

    })
</script>
</html>
