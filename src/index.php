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
    if (count($list) == 2) {
        die('请在漫画储存文件夹内放入漫画文件夹');
    }
    @$sort = $_GET['sort'];
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
        .load {
            margin: 0 auto;
            background-color: darkgray;
            position: fixed;
            width: 100%;
            top: 40%;
            font-size: 15px;
            text-align: center;
        }
    </style>
    <script src="https://lib.baomitu.com/jquery/latest/jquery.js"></script>
</head>
<body>
<div class="body">
    <form action="index.php">
        <input type='text' placeholder='搜索分类' name="sort">
        <input type="submit" value="提交">
    </form>
    <form action="./func/search.php">
        <input type='text' placeholder='搜索名称' name="name">
        <input type="submit" value="提交">
    </form>
    <?php
        for ($i = 0; $i < count($list); $i++) {
            if ($list[$i] !== "." && $list[$i] !== "..") {
                $path = $res . '/' . $list[$i];
                if (is_dir($path)) {
                    $path_info = scandir($path);
                    $key = 0;
                    for ($j = 0; $j < count($path_info); $j++) {
                        if (in_array($path_info[$j], $cover)) {
                            $main_cover = $res . "/" . $list[$i] . "/" . $path_info[$j];
                        } else {
                            if ($auto_cover==true){
                                if ($path_info[$j]!=='.'&&$path_info[$j]!=='..'){
                                    if ($key==0){
                                        $main_cover = $res . '/' . $list[$i] . '/' . $path_info[$j];
                                        $pic_path = $path . '/' . $path_info[$j];
                                        $allow_type = ['image/jpeg','image/png','image/gif'];
                                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                        $type = finfo_file($finfo,$pic_path);
                                        if (in_array($type,$allow_type)) {
                                            $key++;
                                        }
                                    }
                                }
                            }else{
                                $main_cover = './static/icon/none.jpg';
                            }
                        }
                    }
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $type = finfo_file($finfo, $main_cover);
                    $info = file_get_contents($main_cover);
                    $main_cover = "./func/quality.php?q=" . $q . "&path=" . $main_cover;
                    $base64String = 'data:' . $type . ';base64,' . chunk_split(base64_encode($info));
                    @$txt = file_get_contents($res . '/' . $list[$i] . '/' . $classify);
                    if ($txt==false){
                        $txt = "暂无标签";
                    }
                    if (is_null($sort)) {
                        print "
                            <div class='container'>
                                <a href='./func/detail.php?name=$list[$i]'>
                                   <div class='pic'>
                                    <p class='classify'>$txt</p>
                                        <img src='$base64String' alt='封面'>
                                        <p>$list[$i]</p>
                                    </div>
                                </a>
                            </div>
                    ";
                    } else {
                        if (strstr($txt, $sort)) {
                            print "
                            <div class='container'>
                                <a href='./func/detail.php?name=$list[$i]'>
                                   <div class='pic'>
                                    <p class='classify'>$txt</p>
                                        <img src='$base64String' alt='封面'>
                                        <p>$list[$i]</p>
                                    </div>
                                </a>
                            </div>
                    ";
                        }
                    }
                }
            }
        }
    ?>
</div>
</body>
<script>
    $(".pic").click(function () {
        $("body").append("<div class='load'><div class='loading'></div><h1>如果你看见这个圈，说明你的浏览器正在预加载中,请耐心等待...</h1></div>");
    })
    window.addEventListener('pageshow', function () {
        if ($(".load").length === 1) {
            $(".load").remove();
        }
    })
    $(function () {
        initPageHistory();

        function initPageHistory() {
            window.addEventListener('pageshow', function (event) {
                if (event.persisted || window.performance && window.performance.navigation.type == 2) {
                    console.log('window.performance.navigation.type: ' + window.performance.navigation.type);
                    window.location.reload();
                }
            }, false);
        }

    })
</script>
</html>
