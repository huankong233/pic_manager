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
    <link rel='stylesheet' href='../static/css/index.css'>
</head>
<body>
<div class='body'>
    <h1 style="text-align: center">搜索：<?php echo $_GET['name'] ?></h1>
    <br>
    <?php
        for ($i = 0; $i < count($search); $i++) {
            if ($search[$i] !== '.' && $search[$i] !== '..') {
                $path = $search[$i];
                $path_info = scandir($path);
                for ($j = 0; $j < count($path_info); $j++) {
                    if (in_array($path_info[$j], $cover)) {
                        $main_cover = $search[$i] . '/' . $path_info[$j];
                    } else {
                        $main_cover = '../static/icon/none.jpg';
                    }
                }
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $type = finfo_file($finfo, $main_cover);
                $info = file_get_contents($main_cover);
                $main_cover = './func/quality.php?q=' . $q . '&path=' . $main_cover;
                $base64String = 'data:' . $type . ';base64,' . chunk_split(base64_encode($info));
                $name = str_replace("../pic/","",$search[$i]);
                print "
                            <div class='pic'>
                                <a href='./detail.php?name=$name'>
                                    <img src='$base64String' alt='封面'>
                                    <p>$name</p>
                                </a>
                            </div>
                    ";
            }
        }


    ?>
</div>
</body>
</html>