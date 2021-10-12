<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo "漫画：" . $_GET['name'] ?></title>
    <link rel="stylesheet" href="../static/css/post.css">
</head>
<body>
<div class="inner">
    <?php
        require_once "../config.php";
        @$name = $_GET['name'];
        $res = "." . $res;
        if (is_dir($res)) {
            $list = scandir($res);
        } else {
            die('漫画储存路径无法访问或不存在！');
        }

        //判断漫画是否存在
        if (in_array($name, $list)) {
            $path = $res . "/" . $name;
            $pic_name = scandir($path);
            $now = 0;
            for ($i = 0; $i < count($pic_name); $i++) {
                if ($pic_name[$i] !== "." && $pic_name[$i] !== "..") {
                    $pic_path = $path . '/' . $pic_name[$i];
                    $allow_type = ['image/jpeg','image/png','image/gif'];
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $type = finfo_file($finfo,$pic_path);
                    if (in_array($type,$allow_type)){
                        $server_host = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . str_replace('detail.php', '', $_SERVER['PHP_SELF']);
                        $url = $server_host . 'quality.php?q=' . $q . '&path=' . $path . '/' . $pic_name[$i];
                        if ($to_base64==true){
                            $link = preg_replace('/ /', '%20', $url);
                            $info = file_get_contents($link);
                            $base64String = 'data:image/png;base64,' . chunk_split(base64_encode($info));
                        }
                        if (isset($base64String)){
                            echo "<img src='$base64String' alt='这是第{$now}张图'>";
                        }else{
                            echo "<img src='$url' alt='这是第{$now}张图'>";
                        }
                        $now++;
                    }
                }
            }
        } else {
            die("漫画不存在");
        }
    ?>
</div>
<div class="download">
    <button onclick="download()">下载</button>
</div>
</body>
<script>
    function download() {
        window.open('<?php echo $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . str_replace("detail", "download", $_SERVER['REQUEST_URI'])?>');
    }
</script>
</html>
