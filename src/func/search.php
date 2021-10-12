<?php
    require_once "../config.php";
    if (!isset($_GET['name'])) {
        die("接口使用错误！");
    }
    $search = [];
    $name = preg_split('//u', $_GET['name'], -1, PREG_SPLIT_NO_EMPTY);
    $count = count($name);
    for ($i = 0; $i <= $count * 2; $i += 2) {
        array_splice($name, $i, 0, "*");
    }
    $name = implode($name);
    $search = glob("." . $res . "/" . $name, GLOB_NOCHECK);
    $path = '.' . $res . '/' . $name;
    if ($search[0] == $path) {
        die("<h1>搜索结果为空</h1>");
    }
?>
<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>搜索内容:"<?php echo $_GET['name'] ?>"</title>
<!--    <link rel='stylesheet' href='../static/css/index.css'>-->

    <link rel='stylesheet' href='../static/css/index.css'>
    <link rel='stylesheet' href='../static/css/load.css'>
    <link rel='stylesheet' href='../static/css/main.css'>
    <link rel='stylesheet' href='../static/css/460.css'>
    <link rel='stylesheet' href='../static/css/650.css'>
    <link rel='stylesheet' href='../static/css/950.css'>
    <link rel='stylesheet' href='../static/css/1250.css'>
    <link rel='stylesheet' href='../static/css/1450.css'>
</head>
<body>
<div class='body'>
    <h1 style="text-align: center">搜索：<?php echo $_GET['name'] ?></h1>
    <form action='../index.php'>
        <input type='text' placeholder='搜索分类' name='sort'>
        <input type='submit' value='提交'>
    </form>
    <form action='./search.php'>
        <input type='text' placeholder='搜索名称' name='name'>
        <input type='submit' value='提交'>
    </form>
    <br>
    <?php
        for ($i = 0; $i < count($search); $i++) {
            if ($search[$i] !== '.' && $search[$i] !== '..') {
                $path = $search[$i];
                $path_info = scandir($path);
                $key = 0;
                for ($j = 0; $j < count($path_info); $j++) {
                    if (in_array($path_info[$j], $cover)) {
                        $main_cover = $search[$i] . '/' . $path_info[$j];
                    } else {
                        if ($auto_cover == true) {
                            if ($path_info[$j] !== '.' && $path_info[$j] !== '..') {
                                if ($key == 0) {
                                    $main_cover = $search[$i] . '/' . $path_info[$j];
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
                            $main_cover = '../static/icon/none.jpg';
                        }
                    }
                }
                $server_host = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                if (strstr($server_host, '.php')) {
                    $server_host = dirname($server_host);
                }
                $local_cover = $main_cover;
                $main_cover = $server_host . '/quality.php?q=' . $q . '&path=' . $main_cover;
                if ($to_base64 == true) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $type = finfo_file($finfo, $local_cover);
                    $info = file_get_contents($main_cover);
                    $base64String = 'data:' . $type . ';base64,' . chunk_split(base64_encode($info));
                } else {
                    $base64String = $main_cover;
                }
                $name = str_replace("../pic/","",$search[$i]);
                print "
                            <div class='container'>
                                <a href='./detail.php?name=$name'>
                                   <div class='pic'>
                                        <img src='$base64String' alt='封面'>
                                        <p>$name</p>
                                    </div>
                                </a>
                            </div>
                    ";
            }
        }


    ?>
</div>
</body>
</html>