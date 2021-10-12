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
    $server_host = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    if (strstr($server_host, '.php')) {
        $server_host = dirname($server_host);
    }
    if (strstr($server_host, '.php?sort=')) {
        $server_host = substr($server_host, 0, strpos($server_host, '?sort'));
        $server_host = dirname($server_host);
    }
    if (!strstr($_SERVER['REQUEST_URI'], 'index.php')) {
        header("Location:index.php");
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
    <link rel="stylesheet" href="./static/css/main.css">
    <link rel="stylesheet" href="./static/css/460.css">
    <link rel="stylesheet" href="./static/css/650.css">
    <link rel="stylesheet" href="./static/css/950.css">
    <link rel="stylesheet" href="./static/css/1250.css">
    <link rel="stylesheet" href="./static/css/1450.css">
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
<body style="background-color: #444444;">
<div class='nav_top'>
    <ul class='nav'>
        <li><a href='<?php echo $server_host ?>'>首页</a></li>
        <li><a href='./func/classification.php'>分类</a></li>
        <li><a href='https://dl.huankong.top'>里番</a></li>
        <li><a href='https://www.huankong.top'>幻空仓库</a></li>
        <li><a href='https://www.huankong.top/sjgj'>司机工具</a></li>
    </ul>
</div>
<div class="body">
    <form action="index.php">
        <input class="search" type='text' placeholder='搜索分类' name="sort">
        <input class="submit" type="submit" value="提交">
    </form>
    <form action="./func/search.php">
        <input class="search" type='text' placeholder='搜索名称' name="name">
        <input class="submit" type="submit" value="提交">
    </form>
    <div class="body">

        <?php
            for ($i = 0; $i < count($list); $i++) {
                if ($list[$i] == '.' || $list[$i] == '..') {
                    unset($list[$i]);
                }
            }
            array_unshift($list, "占位符");
            $list = array_values($list);
            $pageSize = 15;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $startRow = ($page - 1) * $pageSize;
            if ($startRow == 0) {
                $startRow = 1;
            }
            $records = count($list);
            $pages = ceil($records / $pageSize);
            if ($pages == 0) {
                $pages = 1;
            }
            if ($page < 0 || $page > $pages) {
                //页数错误
                echo "<h1 style='color: red'>请求出错！</h1>";
                echo '<h2>3秒后自动回到首页</h2>';
                header('refresh:3;url=./index.php');
                die();
            }
            if ($startRow + $pageSize > $records) {
                $end = $startRow + $records - $startRow;
            } else {
                $end = $startRow + $pageSize;
            }
            for ($i = $startRow; $i < $end; $i++) {
                $path = $res . '/' . $list[$i];
                if (is_dir($path)) {
                    $path_info = scandir($path);
                    $key = 0;
                    for ($j = 0; $j < count($path_info); $j++) {
                        if (in_array($path_info[$j], $cover)) {
                            $main_cover = $res . '/' . $list[$i] . '/' . $path_info[$j];
                        } else {
                            if ($auto_cover == true) {
                                if ($path_info[$j] !== '.' && $path_info[$j] !== '..') {
                                    if ($key == 0) {
                                        $main_cover = $res . '/' . $list[$i] . '/' . $path_info[$j];
                                        $pic_path = $path . '/' . $path_info[$j];
                                        $allow_type = ['image/jpeg', 'image/png', 'image/gif'];
                                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                        $type = finfo_file($finfo, $pic_path);
                                        if (in_array($type, $allow_type)) {
                                            $key++;
                                        }
                                    }
                                }
                            } else {
                                $main_cover = './static/icon/none.jpg';
                            }
                        }
                    }
                    $local_cover = $main_cover;
                    $main_cover = $server_host . '/func/quality.php?q=' . $q . '&path=' . $main_cover;
                    if ($to_base64 == true) {
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $type = finfo_file($finfo, $local_cover);
                        $info = file_get_contents($main_cover);
                        $base64String = 'data:' . $type . ';base64,' . chunk_split(base64_encode($info));
                    } else {
                        $base64String = $main_cover;
                    }
                    @$txt = file_get_contents($res . '/' . $list[$i] . '/' . $classify);
                    if ($txt == false) {
                        $txt = '暂无标签';
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
        ?>
    </div>
    <div class="pagelist">
        <div style='margin-top: 20px;'>
            <?php
                if ($page - 1 != 0) {
                    echo "<a href='?page=" . ($page - 1.) . "'><上一页</a>";
                }
                $start = 0;
                $end = 0;
                if ($page <= 6) {
                    $start = 1;
                    if ($pages <= 10) {
                        $end = $pages;
                    } else {
                        $end = 10;
                    }
                } else if ($page > $pages - 4) {
                    $start = $pages - 9;
                    $end = $page + ($pages - $page);
                } else if ($pages >= 10) {
                    $start = $page - 5;
                    $end = $page + 4;
                }
                for ($i = $start; $i <= $end; $i++) {
                    if ($page == $i) {
                        echo "<span>$i</span>";
                    } else {
                        echo "<a href='?page=$i'>$i</a>";
                    }
                }
                if ($page != $pages) {
                    echo "<a href='?page=" . ($page + 1.) . "'>下一页></a>";
                }
                echo "<input type='number' placeholder='输入想要切换的页数' style='margin-top: 20px;margin-bottom: 10px' class='changepage' onkeydown='calAge(event)'>";
                echo "<input type='button' onclick='goto()' value='跳转' style='transform: translateY(1px);margin-left: 5px'>"
            ?>
        </div>
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

    function goto() {
        let page = $('.changepage').val();
        if (page === '') {
            alert('请输入需要跳转的页面！');
        } else {
            location.href = './index.php?page=' + $('.changepage').val();
        }
    }

    function calAge(e) {
        let evt = window.event || e;
        if (evt.keyCode == 13) {
            goto();
        }
    }

    $(function (){
        // document.write($('.nav_top').css('width'));
        // document.write(parseFloat(window.innerWidth))
    })
</script>
</html>
